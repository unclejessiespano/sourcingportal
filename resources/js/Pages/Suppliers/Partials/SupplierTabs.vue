<script setup>
import { RectangleStackIcon, BuildingOfficeIcon, CreditCardIcon, UserIcon, UsersIcon, TrophyIcon, ClipboardDocumentCheckIcon, ChartBarIcon } from '@heroicons/vue/20/solid'
const props = defineProps(['supplier', 'active'])
const tabs = [
    { name: 'Dashboard', href: '/supplier/'+props.supplier.slug, icon: ChartBarIcon, current: props.active==='Dashboard' ? true : false  },
    { name: 'Open Orders', href: '/supplier/'+props.supplier.slug+'/openorders', icon: RectangleStackIcon, current: props.active==='Open Orders' ? true : false  },
    { name: 'Company', href: '/supplier/'+props.supplier.slug+'/company', icon: BuildingOfficeIcon, current: props.active==='Company' ? true : false },
    { name: 'Network', href: '/supplier/'+props.supplier.slug+'/network', icon: UsersIcon, current: props.active==='Network' ? true : false },
    { name: 'Activity', href: '/supplier/'+props.supplier.slug+'/activity', icon: CreditCardIcon, current: props.active==='Activity' ? true : false },
    { name: 'Weekly Meeting', href: '/meeting/1/', icon: ClipboardDocumentCheckIcon, current: props.active==='Meeting' ? true : false },
]
</script>
<!--
  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>
    <div class="mb-6">
        <div class="sm:hidden px-4">
            <label for="tabs" class="sr-only">Select a tab</label>
            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
            <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a v-for="tab in tabs" :key="tab.name" :href="tab.href" :class="[tab.current ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium']" :aria-current="tab.current ? 'page' : undefined">
                        <component :is="tab.icon" :class="[tab.current ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500', '-ml-0.5 mr-2 h-5 w-5']" aria-hidden="true" />
                        <span>{{ tab.name }}</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>


