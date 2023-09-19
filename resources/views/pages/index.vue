<template>
    <div class="loginPage">
        <Head title="Login" />
        <!-- login form -->
        <form @submit.prevent="login" class="loginForm">
            <h1 class="text-blue-500 mb-2">Sign in</h1>
            <input type="text" name="" id="" class="input-text-white mt-3" placeholder="Email" v-model="credentials.email">
            <div v-if="errors.email" class="text-[14px] text-red-500">{{ errors.email }}</div>
            <input type="text" name="" id="" class="input-text-white mt-3" placeholder="Password" v-model="credentials.password">
            <div v-if="errors.password" class="text-[14px] text-red-500">{{ errors.password }}</div>
            <div class="form-control mt-3">
                <label class="label cursor-pointer w-fit">
                    <span class="label-text">Remember me</span> 
                    <input type="checkbox" class="checkbox checkbox-sm ml-3" />
                </label>
            </div>
            <button type="submit" class="btn-blue w-fit mt-3 self-end">Login</button>
        </form>
    </div>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import { reactive } from 'vue';
    import { router } from '@inertiajs/vue3';
    defineProps(['errors'])
    const credentials = reactive({
        email: null,
        password: null,
    });

    // login function
    function login() {
        router.visit('/login', {
            method: 'post',
            data: {
                email: credentials.email,
                password: credentials.password
            },
            preserveState: true,
        })
    }
</script>

<style scoped>
    .loginPage {
        @apply bg-gray-100 w-full min-h-screen flex justify-center items-center md:px-[10%] px-[5%];
    }
    .loginForm {
        @apply bg-white p-5 rounded-md w-full max-w-[600px] shadow-md flex flex-col;
    }
</style>