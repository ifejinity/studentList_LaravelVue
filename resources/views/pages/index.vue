<template>
    <div class="loginPage">
        <head>
            <title>Student list | Login</title>
        </head>
        <!-- login form -->
        <form @submit.prevent="login" class="loginForm">
            <h1 class="text-blue-500 mb-2">Sign in</h1>
            <input type="text" class="input-text-white mt-3" placeholder="Email" v-model="credentials.email">
            <span v-if="errors.email" class="text-[14px] text-red-500">{{ errors.email }}</span>
            <input type="password" class="input-text-white mt-3" placeholder="Password" v-model="credentials.password">
            <span v-if="errors.password" class="text-[14px] text-red-500">{{ errors.password }}</span>
            <div class="form-control mt-3">
                <label class="label cursor-pointer w-fit">
                    <span class="label-text">Remember me</span> 
                    <input type="checkbox" v-model="credentials.remember" class="checkbox checkbox-sm ml-3" />
                </label>
            </div>
            <button type="submit" class="btn-blue w-fit mt-3 self-end">Login</button>
        </form>
    </div>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3';
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps(['errors'])

    // user credentials
    const credentials = useForm({
        email: 'mrlonzanida08@gmail.com',
        password: null,
        remember: false,
    });
    
    // login function
    function login() {
        router.visit('/login', {
            method: 'post',
            data: credentials,
            preserveState: true,
            onSuccess: () => {
                success('Login success!');
            },
            onError: () => {
                error(props.errors.message ?? 'Login failed!');
            },
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