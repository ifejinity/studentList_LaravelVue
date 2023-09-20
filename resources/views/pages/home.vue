<template>
    <div>
        <Head>
            <title>Student list | Home</title>
        </Head>
        <div>
            
        </div>
        <div class="overflow-x-auto">
            <table class="table" id="myTable">
                <!-- head -->
                <thead>
                <tr>
                    <th>
                        <div class="dropdown dropdown-xs">
                            <label tabindex="0" class="btn-sm btn normal-case bi bi-three-dots-vertical"></label>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><button @click="mutiDelete">Delete selected</button></li>
                            </ul>
                        </div>
                    </th>
                    <th>Student type</th>
                    <th>ID number</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>City</th>
                    <th>Mobile number</th>
                    <th>Grades</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="list">
                    <tr v-for="item in student">
                        <td>
                            <input type="checkbox" class="checkbox checkbox-sm" :value="item.id_number"/>
                        </td>
                        <td>{{ item.student_type }}</td>
                        <td>{{ item.id_number }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.age }}</td>
                        <td>{{ item.gender }}</td>
                        <td>{{ item.city }}</td>
                        <td>{{ item.mobile_number }}</td>
                        <td>{{ parseFloat(item.grades, 2) }}</td>
                        <td>{{ item.email }}</td>
                        <td class="flex gap-2">
                            <button class="btn btn-sm bg-red-500 hover:bg-red-400 text-white" @click="deleteStudent(item.id_number)">Delete</button>
                            <button class="btn btn-sm bg-blue-500 hover:bg-blue-400 text-white" @click="editStudent(item.id_number)">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="student == 0" class="w-full flex justify-center">
                <h1 class="text-[50px] text-blue-500/30">No data</h1>
            </div>
        </div>
        <button type="button" class="btn-blue absolute bottom-[24px] right-[24px]" @click="createPage">Add Student</button>
    </div>
</template>

<script>
    import { Head } from '@inertiajs/vue3';
    import AuthLayout from '../shared/auth.vue';
    import { router } from '@inertiajs/vue3';

    export default {
        layout: AuthLayout,
        props: {
            student: Object
        },
        methods: {
            createPage() {
                router.get('/create')
            },
            deleteStudent(id) {
                function confirmedCallback(isConfirmed) {
                    if (isConfirmed) {
                        router.visit('/delete', {
                            method: 'delete', 
                            data: {id_number:id},
                            onSuccess: () => {
                                success('Student deleted!');
                            },
                            onError: () => {
                                error('Deletion failed!')
                            },
                        })
                    }
                }
                confirmation(
                    'Are you sure?',
                    "You won't be able to revert this!",
                    'warning',
                    true,
                    '#3085d6',
                    '#d33',
                    'Yes, proceed!',
                    confirmedCallback
                )
            },
            editStudent(id) {
                router.visit('/edit', {
                    method: 'get',
                    data: { id_number:id },
                });
            },
            mutiDelete() {
                const selected = document.querySelectorAll('.checkbox:checked');
                let selectedIds = [];
                selected.forEach(ids => {
                    selectedIds.push(ids.value);
                });
                function confirmedCallback(isConfirmed) {
                    if (isConfirmed) {
                        router.visit('/multiDelete', {
                            method: 'delete', 
                            data: {id_number:selectedIds},
                            onSuccess: () => {
                                success('Student deleted!');
                            },
                            onError: () => {
                                error('Deletion failed!');
                            },
                        })
                    }
                }
                confirmation(
                    'Are you sure?',
                    "You won't be able to revert this!",
                    'warning',
                    true,
                    '#3085d6',
                    '#d33',
                    'Yes, proceed!',
                    confirmedCallback
                )
            }
        }
    }
</script>

<style lang="scss" scoped>
    
</style>