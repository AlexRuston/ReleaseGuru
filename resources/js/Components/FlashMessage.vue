<script setup>

const props = defineProps({
    message: {
        type: String,
        default: 'Success!',
    },
    messageType: {
        type: String,
        default: 'success',
    },
});
</script>

<template>
    <transition name="fade">
        <div class="fixed top-0 right-0 m-6 fade-out-element" v-if="isVisible" >
            <div
                :class="{
            'bg-red-200 text-red-900' :props.messageType === 'error',
            'bg-green-200 text-green-900': props.messageType === 'success',
          }"
                class="rounded-lg shadow-md p-6 pr-10"
                style="min-width: 240px"
            >
                <div class="flex items-center">
                    {{ props.message }}
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
export default {
    data() {
        return {
            isVisible: true,
        };
    },
    mounted() {
        this.fadeOut();
    },
    methods: {
        fadeOut() {
            setTimeout(() => {
                this.isVisible = false;
            }, 5000);
        },
    },
};
</script>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity 1s ease;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
}
</style>
