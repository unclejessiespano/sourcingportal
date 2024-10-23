<script setup>
import {router} from "@inertiajs/vue3";
import {reactive, ref} from 'vue'
import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid'

const props = defineProps(['errors', 'roles', 'suppliers'])
const verb = [!props.touchpoint] ? "Create" : "Update";
const assigned_suppliers = ref([])
let form = reactive({
    name: null,
    email: null,
    password:null,
    password_confirmation:null,
    role:null,
    assigned_suppliers:assigned_suppliers
})

function submitForm(){
    console.log(form);
    router.post('/admin/users/store', form, {
        preserveScroll:true,
        preserveState:true
    })
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <template v-if="touchpoint"></template>
                <template v-else>
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Create a user</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600"></p>
                </template>


                <div class="mt-10 grid grid-cols-6 gap-x-6 gap-y-8 sm:grid-cols-2">


                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" v-model="form.name" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="$page.props.errors.name" class="mt-2 text-sm text-red-600">{{ $page.props.errors.name}}</div>
                        </div>
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" v-model="form.email" name="email" id="email" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="$page.props.errors.email" class="mt-2 text-sm text-red-600">{{ $page.props.errors.email }}</div>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="password" v-model="form.password"  name="password" id="password" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="$page.props.errors.password" class="mt-2 text-sm text-red-600">{{ $page.props.errors.password}}</div>
                        </div>
                    </div>
                    <div>
                        <label for="password2" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="password" v-model="form.password_confirmation" name="password_confirmation" id="password_confirmation" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="$page.props.errors.password_confirmation" class="mt-2 text-sm text-red-600">{{ $page.props.errors.password_confirmation }}</div>
                        </div>
                    </div>
                    <div>
                        <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Role</label>
                        <div class="mt-2">
                            <select v-model="form.role" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                <option></option>
                                <option v-for="role in roles" :value="role.name">{{role.name}}</option>
                            </select>
                        </div>
                        <div v-if="$page.props.errors.role" class="mt-2 text-sm text-red-600">{{ $page.props.errors.role }}</div>
                    </div>

                </div>
                <div class="mt-10">
                    <label for="country" class="text-base font-semibold leading-7 text-gray-900">Suppliers</label>
                </div>
                <div class="mt-5 grid grid-cols-6 gap-x-6 gap-y-8 sm:grid-cols-3">
                    <div v-for="supplier in suppliers" :key="supplier.id">
                        <input type="checkbox" v-model="assigned_suppliers" name="assigned_suppliers" :value="supplier.id" />
                        {{supplier.name}}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{verb}} User</button>
        </div>
    </form>
</template>

<style scoped>

</style>
