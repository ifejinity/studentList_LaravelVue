<template>
    <div>
        <title>{{ title }}</title>
        <h1 class="text-blue-500">{{ header }}</h1>
        <StudentForm :method="method" :errors="errors" :student="student" class="mt-[50px]"/>
    </div>
</template>

<script>
    import AuthLayout from '../shared/auth.vue';
    import StudentForm from '../shared/studentForm.vue';

    export default {
        layout: AuthLayout,
        props: {
            title: String,
            header: String,
            method: String,
            errors: Object,
            student: Object
        },
        components: {
            StudentForm
        }
    }
</script>

<style lang="scss" scoped>

</style>