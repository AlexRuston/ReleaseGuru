<template>
    <Head title="Users"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-400 leading-tight">
                Edit User - {{ user.id }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto relative">
                        <form @submit.prevent="submit">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-600 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Name
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Email
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Role
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-slate-800 border-b border-b-slate-700">
                                        <td class="py-4 px-6">
                                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                                            <InputError class="mt-2" :message="$page.props.errors.name" />
                                        </td>
                                        <td class="py-4 px-6">
                                            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
                                            <InputError class="mt-2" :message="$page.props.errors.email" />
                                        </td>
                                        <td class="py-4 px-6">
                                            <select v-model="role" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                <option disabled value="">- -</option>
                                                <option v-for="role in roles" :key="role.id">{{ role.name }}</option>
                                            </select>
                                            <InputError class="mt-2" :message="$page.props.errors.email" />
                                        </td>
                                        <td class="py-4 px-6">
                                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Update
                                            </PrimaryButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    user: Object,
    roles: Object,
})

const form = useForm({
    name: props.user?.name,
    email: props.user?.email,
});

const submit = () => {
    Inertia.post(`/users/${props.user.id}`, {
        _method: "put",
        name: form.name,
        email: form.email,
        role: form.role,
    });
};

</script>
