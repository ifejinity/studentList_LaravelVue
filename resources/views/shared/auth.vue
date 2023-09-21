<template>
    <header class="header">
        <Link href="/home" as="button" method="get" class="text-blue-500 cursor-pointer btn normal-case btn-ghost text-[18px]" @click="backHome">StudentList</Link>
        <div>
            <button type="button" class="btn-blue" @click="logout">Logout</button>
        </div>
    </header>
    <div class="w-full flex flex-col md:px-[10%] px-[5%]">
        <slot></slot>
    </div>
</template>

<script setup>
    import { router } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'
    import customJs from '../../js/global';

    function logout() {
        function confirmedCallback(isConfirmed) {
            if (isConfirmed) {
                router.get('/logout')
            }
        }
        customJs.confirmation(
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
</script>

<style scoped>
    .header {
        @apply w-full flex justify-between p-5;
    }

</style>