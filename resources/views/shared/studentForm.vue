<template>
    <form class="w-full flex flex-col max-w-[900px] mx-auto" id="form">
        <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
            <div class="form-control w-full">
                <label class="label">
                    <p class="label-text">Student type</p>
                </label>
                <select name="student_type" class="select bg-gray-200" v-model="data.student_type">
                    <option value="" disabled selected>Select</option>
                    <option value="local">Local</option>
                    <option value="foreign">Foreign</option>
                </select>
                <span v-if="errors.student_type" class="text-[14px] text-red-500 mt-1">{{ errors.student_type }}</span>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <p class="label-text">Email</p>
                </label>
                <input type="text" name="email" class="input bg-gray-200" v-model="data.email">
                <span v-if="errors.email" class="text-[14px] text-red-500 mt-1">{{ errors.email }}</span>
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
            <div class="form-control w-full">
                <label class="label">
                    <p class="label-text">Name</p>
                </label>
                <input type="text" name="name" class="input bg-gray-200" v-model="data.name">
                <span v-if="errors.name" class="text-[14px] text-red-500 mt-1">{{ errors.name }}</span>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <p class="label-text">Age</p>
                </label>
                <input type="number" name="age" class="input bg-gray-200" v-model="data.age">
                <span v-if="errors.age" class="text-[14px] text-red-500 mt-1">{{ errors.age }}</span>
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
            <div class="form-control w-full">
                <label class="label">
                    <p class="label-text">Gender</p>
                </label>
                <select name="gender" class="select bg-gray-200" v-model="data.gender">
                    <option disabled selected>Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <span v-if="errors.gender" class="text-[14px] text-red-500 mt-1">{{ errors.gender }}</span>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <p class="label-text">City</p>
                </label>
                <input type="text" name="city" class="input bg-gray-200" v-model="data.city">
                <span v-if="errors.city" class="text-[14px] text-red-500 mt-1">{{ errors.city }}</span>
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
            <div class="form-control w-full">
                <label class="label">
                    <p class="label-text">Mobile number</p>
                </label>
                <input type="text" name="mobile_number" class="input bg-gray-200" v-model="data.mobile_number">
                <span v-if="errors.mobile_number" class="text-[14px] text-red-500 mt-1">{{ errors.mobile_number }}</span>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <p class="label-text">Grades</p>
                </label>
                <input type="text" name="grades" class="input bg-gray-200" v-model="data.grades">
                <span v-if="errors.grades" class="text-[14px] text-red-500 mt-1">{{ errors.grades }}</span>
            </div>
        </div>
        <input type="hidden" name="id_number" v-model="data.id_number">
        <button type="button" class="btn-blue mt-5 self-end max-w-[200px] w-full" :id="method" @click="save">Save</button>
    </form>
</template>

<script setup>
    import { router } from '@inertiajs/vue3';
    import { useForm } from '@inertiajs/vue3';

    const data = useForm({
        id_number: props.student.id_number ?? null,
        student_type: props.student.student_type ?? null,
        name: props.student.name ?? null,
        age: props.student.age ?? null,
        gender: props.student.gender ?? null,
        city: props.student.city ?? null,
        mobile_number: props.student.mobile_number ?? null,
        grades: props.student.grades == null ? null : parseFloat(props.student.grades, 2),
        email: props.student.email ?? null,
    })
    
    const props = defineProps(['method', 'errors', 'student']);

    function save(event) {
        // create
        if(event.target.id === 'create') {
            function confirmedCallback(isConfirmed) {
                if (isConfirmed) {
                    router.visit('/createProcess', {
                        method: 'post', 
                        data: data,
                        preserveState: true,
                        onSuccess: () => {
                            success('Student added!');
                            router.get('/home');
                        },
                        onError: () => {
                            error('Failed to add student!')
                        },
                    })
                }
            }
            confirmation(
                'Are you sure?',
                "You're about to create a student",
                'warning',
                true,
                '#3085d6',
                '#d33',
                'Yes, proceed!',
                confirmedCallback
            )
        } 
        // edit
        else if(event.target.id === 'edit') {
            function confirmedCallback(isConfirmed) {
                if (isConfirmed) {
                    router.visit('/editProcess', {
                        method: 'post', 
                        data: data,
                        preserveState: true,
                        onSuccess: () => {
                            success('Student updated!');
                            router.get('/home');
                        },
                        onError: () => {
                            error('Failed to update student!')
                        },
                    })
                }
            }
            confirmation(
                'Are you sure?',
                "You're about to update a student",
                'warning',
                true,
                '#3085d6',
                '#d33',
                'Yes, proceed!',
                confirmedCallback
            )
        }
    }
</script>

<style scoped>

</style>