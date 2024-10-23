<script setup>
import Avatar from "@/Components/Avatar.vue";
const props = defineProps(['users'])
import moment from 'moment';
</script>

<template>
    <div class="sm:flex sm:items-center mb-10">
        <div class="sm:flex-auto">&nbsp;</div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="/admin/users/create"  class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create User</a>
        </div>
    </div>
    <ul role="list" class="divide-y divide-gray-100">
        <li v-for="user in users" :key="user.id" class="flex justify-between gap-x-6 py-5">
            <div class="flex min-w-0 gap-x-4">
                <Avatar :name="user.name" />
                <div class="min-w-0 flex-auto">
                    <p class="text-md font-semibold leading-6 text-gray-900">
                        <a :href="'/admin/user/'+user.id">{{ user.name }}</a>
                        <span v-if="user.suppliers" class="ml-2 inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{user.suppliers.length}} suppliers</span>
                    </p>
                    <p class="mt-1 truncate text-md leading-5 text-gray-500">{{ user.email }}</p>
                </div>
            </div>
            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                <span v-for="role in user.roles" class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ role.name }}</span>
                <p class="mt-1 text-xs leading-5 text-gray-500">
                    Added <time :datetime="user.created_at">{{ moment(user.created_at).format('LL') }}</time>
                </p>

            </div>
        </li>
    </ul>
</template>

<style scoped>

</style>
