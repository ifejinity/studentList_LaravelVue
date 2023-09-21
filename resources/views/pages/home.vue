<template>
    <div class="k">
        <title>Student list | Home</title>
        <div class="flex gap-2 justify-between md:flex-row flex-col">
            <div class="dropdown dropdown-xs self-end">
                <label tabindex="0" class="btn-sm btn normal-case bi bi-caret-down-fill">Multiple action</label>
                <ul tabindex="0" class="dropdown-content z-[2] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><button @click="selectAll($event)">Select all</button></li>
                    <li><button @click="mutiDelete">Delete selected</button></li>
                </ul>
                <p class="mt-2 text-[14px] font-[500]">Number of records: {{ student.length }}</p>
            </div>
            <div class="flex gap-3">
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Search</span>
                    </label>
                    <input type="text" @input="search($event)" class="input input-bordered" placeholder="Name or ID number"/>
                </div>
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Filter Student type</span>
                    </label>
                    <select @change="filter($event)" class="select select-bordered w-full max-w-xs" :value="type">
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
                    <tr v-for="item in student" class="hover:bg-blue-200/30">
                        <td>
                            <input type="checkbox" class="checkbox checkbox-sm" :value="item.id_number"/>
                        </td>
                        <td>
                            <div class="indicator">
                                <span class="indicator-item indicator-start badge badge-success text-white" v-if="diffMins(item.updated_at) <= 5">new</span> 
                                <p class="pt-2">{{ item.student_type }}</p>
                            </div>
                        </td>
                        <td>{{ item.id_number }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.age }}</td>
                        <td>{{ item.gender }}</td>
                        <td>{{ item.city }}</td>
                        <td><a :href="`tel:${item.mobile_number}`" class="link text-blue-500">{{ item.mobile_number }}</a></td>
                        <td>{{ parseFloat(item.grades, 2) }}</td>
                        <td><a :href="`mailto:${item.email}`" class="link text-blue-500">{{ item.email }}</a></td>
                        <td class="flex gap-2">
                            <button class="btn btn-delete text-base bi bi-trash3" @click="deleteStudent(item.id_number)"></button>
                            <button class="btn btn-blue text-base bi bi-pencil-square" @click="editStudent(item.id_number)"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="student == 0" class="w-full flex justify-center">
                <h1 class="text-[50px] text-blue-500/30">No data</h1>
            </div>
        </div>
        <button type="button" class="btn-blue fixed bottom-[24px] right-[24px]" @click="createPage">Add Student</button>
    </div>
</template>

<script>
    import { Head } from '@inertiajs/vue3';
    import AuthLayout from '../shared/auth.vue';
    import { router } from '@inertiajs/vue3';
    import customJs from '../../js/global';

    export default {
        layout: AuthLayout,
        props: {
            student: Object,
            type: String
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
                                customJs.success('Student deleted!');
                            },
                            onError: () => {
                                customJs.error('Deletion failed!')
                            }
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
            editStudent(id) {
                router.visit('/edit', {
                    method: 'get',
                    data: { id_number:id },
                });
            },
            selectAll(event){
                if(event.target.innerText == "Select all") {
                    const checkboxes = document.querySelectorAll('.checkbox:not(:checked)');
                    checkboxes.forEach((checkbox) => {
                        if(!checkbox.closest('tr').classList.contains('hidden')){
                            checkbox.checked = true;
                        }
                    });
                    event.target.innerText = "Unselect all"
                } else {
                    const checkboxes = document.querySelectorAll('.checkbox:checked');
                    checkboxes.forEach((checkbox) => {
                        if(!checkbox.closest('tr').classList.contains('hidden')){
                            checkbox.checked = false;
                        }
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
                            data: {id_number:selectedIds},
                            onSuccess: () => {
                                customJs.success('Student deleted!');
                            },
                            onError: () => {
                                customJs.error('Deletion failed!');
                            },
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
                    data: {student_type:type}
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
            search(event) {
                const list = document.querySelectorAll('#list tr');
                list.forEach((e) => {
                    const name = e.getElementsByTagName('td')[3].innerText;
                    const id = e.getElementsByTagName('td')[2].innerText;
                    const pattern = new RegExp(event.target.value.trim(), 'i');
                    if (!pattern.test(name) && !pattern.test(id)) {
                        e.classList.add('hidden');
                    } else {
                        e.classList.remove('hidden');
                    }
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    
</style>