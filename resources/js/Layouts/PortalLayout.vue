<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import FileUpload from "@/Components/FileUpload.vue";
import ScoreBadge from "@/Pages/Suppliers/Partials/ScoreBadge.vue"
import Avatar from "@/Components/Avatar.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Search from "@/Components/Search.vue";
const props = defineProps(['title', 'subtitle', 'score'])


const navigation = [
    { name: 'Dashboard', href: '/dashboard', current: false },
    { name: 'Plants', href: '/plants', current: false },
    { name: 'Suppliers', href: '/suppliers', current: false },
    { name: 'Orders', href: '/orders', current: false },
    { name: 'Finished Parts', href: '/finishedparts', current: false },
    { name: 'Parts', href: '/parts', current: false },
    { name: 'Escalations', href: '/escalations', current: false },
]
const userNavigation = [
    { name: 'Your Profile', href: '#' },
    { name: 'Settings', href: '#' },
]
</script>
<template>
    <!--
      This example requires updating your template:

      ```
      <html class="h-full bg-gray-100">
      <body class="h-full">
      ```
    -->

    <div class="min-h-full">
        <Disclosure as="nav" class="bg-gray-100" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="w-1/2" src="/images/mouker_text.png" alt="Mouker" />
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-300 text-black' : 'hover:text-white hover:bg-indigo-500 hover:bg-opacity-75', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <FileUpload v-if="$page.props.permissions.includes('upload oor')" />


                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-3">
                                <div>
                                    <MenuButton class="relative flex max-w-xs items-center rounded-full bg-gray-500 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
                                        <span class="absolute -inset-1.5" />
                                        <span class="sr-only">Open user menu</span>
                                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500">
                                            <span class="text-xl font-medium leading-none text-white">{{$page.props.auth.user.name.substr(0,1)}}</span>
                                        </span>
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                            <a :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                                        </MenuItem>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton class="relative inline-flex items-center justify-center rounded-md bg-gray-500 p-2 text-indigo-200 hover:bg-gray-500 hover:bg-opacity-75 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-500">
                            <span class="absolute -inset-0.5" />
                            <span class="sr-only">Open main menu</span>
                            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <DisclosurePanel class="md:hidden">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-500 text-white' : 'text-white hover:bg-indigo-500 hover:bg-opacity-75', 'block rounded-md px-3 py-2 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
                </div>
                <div class="border-t border-indigo-700 pb-3 pt-4">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="user.imageUrl" alt="" />
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-white">{{ user.name }}</div>
                            <div class="text-sm font-medium text-indigo-300">{{ user.email }}</div>
                        </div>
                        <button type="button" class="relative ml-auto flex-shrink-0 rounded-full border-2 border-transparent bg-gray-500 p-1 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75">{{ item.name }}</DisclosureButton>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>
        <div class="bg-gray-50 shadow-black">
            <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center">
                            <Search />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center">
                            <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight mr-3">{{title}}</h1>
                            <ScoreBadge :score="score" />

                        </div>
                    </div>
                    <div class="mt-4 flex md:ml-4 md:mt-0">

                        <slot name="header_button"></slot>
                    </div>
                </div>
                <div class="md:flex md:items-center md:justify-between">
                    <slot name="subhead"></slot>
                </div>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template>

