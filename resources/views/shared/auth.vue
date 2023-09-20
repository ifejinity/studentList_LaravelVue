<template>
    <div>
        <header class="header">
            <h2 class="text-blue-500 cursor-pointer" @click="backHome">StudentList</h2>
            <div>
                <button type="button" class="btn-blue" @click.prevent="logout">Logout</button>
            </div>
        </header>
        <div class="w-full flex flex-col md:px-[10%] px-[5%]">
            <slot />
        </div>
    </div>
</template>

<script setup>
    import { router } from '@inertiajs/vue3';

    function logout() {
        function confirmedCallback(isConfirmed) {
            if (isConfirmed) {
                router.get('/logout')
            }
        }
        confirmation(
            'Are you sure?',
            "You're about to logout an account!",
            'warning',
            true,
            '#3085d6',
            '#d33',
            'Yes, proceed!',
            confirmedCallback
        )
    }

    function backHome() {
        router.get('/home');
    }
</script>

<style scoped>
    .header {
        @apply w-full flex justify-between p-5;
    }

</style>