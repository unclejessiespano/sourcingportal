<script setup>

</script>

<template>
    <table class="min-w-full divide-y divide-gray-300">
        <thead>
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Order</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">SKU</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Line</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Days Late</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Value</th>
            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
        </thead>
        <tbody class="bg-white">
        <tr class="even:bg-gray-50">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">name</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">title</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">email</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">role</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">role</td>
            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3">
                <a href="#" class="text-indigo-600 hover:text-indigo-900"
                >Edit<span class="sr-only">, name</span></a
                >
            </td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
