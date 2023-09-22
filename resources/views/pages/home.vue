<template>
    <div>
        <title>Student list | Home</title>
        <div class="flex gap-2 justify-between md:flex-row flex-col sticky top-0 bg-white z-[2] pb-3">
            <div class="dropdown dropdown-xs self-end">
                <label tabindex="0" class="btn-sm btn normal-case bi bi-caret-down-fill">Multiple action</label>
                <ul tabindex="0" class="dropdown-content z-[2] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><button @click="selectAll($event)">Select all</button></li>
                    <li><button @click="mutiDelete">Delete selected</button></li>
                </ul>
                <p class="mt-2 text-[14px] font-[500]">Number of records: {{ student.length }}</p>
            </div>
            <div class="flex gap-3 md:flex-row flex-col">
                <div class="form-control w-full md:max-w-xs">
                    <label class="label">
                        <span class="label-text">Search</span>
                        <Link href="/home" method="get" class="label-text-alt link text-[14px]">Reset</Link>
                    </label>
                    <div class="input-group">
                        <input type="text" class="input input-bordered" placeholder="Name or ID number" id="query"/>
                        <button class="btn btn-square" @click="search()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </button>
                    </div>
                </div>
                <div class="form-control w-full md:max-w-xs">
                    <label class="label">
                        <span class="label-text">Filter Student type</span>
                    </label>
                    <select @change="filter($event)" class="select select-bordered w-full md:max-w-xs" :value="type">
                        <option selected disabled>Select type</option>
                        <option value="">All</option>
                        <option value="foreign">Foreign</option>
                        <option value="local">Local</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th></th>
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
                    <tr v-for="(item, index) in student" :key="index" class="hover:bg-blue-200/30">
                        <td>
                            <input type="checkbox" class="checkbox checkbox-sm" :value="item.id"/>
                        </td>
                        <td>
                            <div class="indicator">
                                <span class="indicator-item indicator-start badge badge-success text-white" v-if="diffMins(item.updated_at) <= 5">new</span> 
                                <p class="pt-2">{{ item.student_type }}</p>
                            </div>
                        </td>
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.age }}</td>
                        <td>{{ item.gender }}</td>
                        <td>{{ item.city }}</td>
                        <td><a :href="`tel:${item.mobile_number}`" class="link text-blue-500">{{ item.mobile_number }}</a></td>
                        <td>{{ parseFloat(item.grades, 2) }}</td>
                        <td><a :href="`mailto:${item.email}`" class="link text-blue-500">{{ item.email }}</a></td>
                        <td class="flex gap-2">
                            <button class="btn btn-delete text-base bi bi-trash3" @click="deleteStudent(item.id)"></button>
                            <Link :href="`edit/${item.id}`" method="get" as="button" type="button" class="btn btn-blue text-base bi bi-pencil-square"></Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="student == 0" class="w-full flex justify-center">
                <h1 class="text-[50px] text-blue-500/30">No available data</h1>
            </div>
        </div>
        <Link method="get" as="button" type="button" class="btn-blue fixed bottom-[24px] right-[24px]" href="/create">Add Student</Link>
    </div>
</template>

<script>
    import AuthLayout from '../shared/auth.vue';
    import { router } from '@inertiajs/vue3';
    import customJs from '../../js/global';


    export default {
        layout: AuthLayout,
        props: {
            student: Object,
            type: String,
            query: String
        },
        methods: {
            deleteStudent(id) {
                function confirmedCallback(isConfirmed) {
                    if (isConfirmed) {
                        router.visit('/delete', {
                            method: 'delete', 
                            data: {id:id},
                            onSuccess: () => {
                                customJs.success('Student deleted!');
                                const checkboxes = document.querySelectorAll('.checkbox:checked');
                                checkboxes.forEach((checkbox) => {
                                    checkbox.checked = false;
                                });
                            },
                            onError: () => {
                                customJs.error('Deletion failed!')
                            },
                            preserveScroll: true,
                        })
                    }
                }
                customJs.confirmation(
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
            selectAll(event){
                if(event.target.innerText == "Select all") {
                    const checkboxes = document.querySelectorAll('.checkbox:not(:checked)');
                    checkboxes.forEach((checkbox) => {
                        checkbox.checked = true;
                    });
                    event.target.innerText = "Unselect all"
                } else {
                    const checkboxes = document.querySelectorAll('.checkbox:checked');
                    checkboxes.forEach((checkbox) => {
                        checkbox.checked = false;
                    });
                    event.target.innerText = "Select all"
                }
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
                            data: {id:selectedIds},
                            onSuccess: () => {
                                customJs.success('Student deleted!');
                                const checkboxes = document.querySelectorAll('.checkbox:checked');
                                checkboxes.forEach((checkbox) => {
                                    checkbox.checked = false;
                                });
                            },
                            onError: () => {
                                customJs.error('Deletion failed!');
                            },
                            preserveScroll: true,
                            preserveState: true
                        })
                    }
                }
                customJs.confirmation(
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
            filter(event) {
                let type = event.target.value;
                router.visit('/home', {
                    method: 'get',
                    data: {student_type:type, search:this.query},
                    preserveScroll: true
                })
            },
            diffMins(date) {
                function calculateMinutesDifference(datetimeString) {
                    const targetDate = new Date(datetimeString);
                    const currentDate = new Date();
                    const timeDifference = targetDate.getTime() - currentDate.getTime();
                    const minutesDifference = Math.floor(timeDifference / (1000 * 60) * -1);
                    return minutesDifference;
                }
                const datetimeString = date;
                const minutesDifference = calculateMinutesDifference(datetimeString);
                return minutesDifference
            },
            search() {
                let query = document.querySelector('#query');
                let type = this.type;
                router.visit('/home', {
                    method: 'get',
                    data: { search:query.value, student_type:type},
                    preserveState: true,
                    preserveScroll: true
                })
            }
        }
    }
</script>

<script setup>
    import { Link } from '@inertiajs/vue3'
</script>

<style lang="scss" scoped>
    
</style>