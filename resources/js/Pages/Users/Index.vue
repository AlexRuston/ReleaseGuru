<template>
    <Head title="Users"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-12 gap-7">
                <div class="col-span-11">
                    <h2 class="font-semibold text-xl text-gray-400 leading-tight">
                        Users - {{ users.length }}
                    </h2>
                </div>
                <div class="...">
                    <Link :href="route('users.create')" as="button" class="font-medium text-red-500 hover:text-red-700 mr-2">
                        <PrimaryButton>
                            Create
                        </PrimaryButton>
                    </Link>
                </div>

            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs text-gray-400 uppercase bg-gray-100 dark:bg-gray-600 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Name
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Email
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id" class="bg-slate-800 border-b border-b-slate-700">
                                    <td class="py-4 px-6">
                                        {{ user.name }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ user.email }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <Link :href="route('users.edit', user.id)" as="button" class="font-medium text-blue-500 hover:text-blue-700 mr-2">
                                            <EditButton>
                                                Edit
                                            </EditButton>
                                        </Link  >
                                        <Link :href="route('users.destroy', user.id)" method="delete" as="button" class="font-medium text-red-500 hover:text-red-700 mr-2">
                                            <DeleteButton>
                                                Delete
                                            </DeleteButton>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { Link } from '@inertiajs/inertia-vue3';
    import EditButton from "@/Components/EditButton.vue";
    import DeleteButton from "@/Components/DeleteButton.vue";
    import PrimaryButton from "@/Components/PrimaryButton.vue";

    defineProps({
        users: Object,
    })
</script>
