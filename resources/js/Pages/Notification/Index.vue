<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { PlusSmallIcon } from '@heroicons/vue/20/solid';
import PageHeading from '@/Components/PageHeading.vue';
import TableHeadCol from '@/Components/TableHeadCol.vue';
import TableFullwidth from '@/Components/TableFullwidth.vue';
import TableRowCol from '@/Components/TableRowCol.vue';
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
  } from '@headlessui/vue'
import { onMounted } from 'vue';
import axios from 'axios';


defineProps({
    notifications: {
        type: Object,
        required: true
    }
})

onMounted(() => {
    setTimeout(()=>{ axios.get(route('api.notifications.read')).then(()=>{router.reload()})}, 10000)
});
</script>

<template>
    <Head title="Notifications" />
    <PageHeading title="Notifications" />
    <div class="mt-8 flow-root overflow-hidden">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <TableFullwidth>
            <template #thead>
                <th scope="col" class="relative isolate py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">

                    <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-b-gray-200" />
                    <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-b-gray-200" />
                </th>
                <TableHeadCol></TableHeadCol>
                <th scope="col" class="relative py-3.5 pl-3">
                    <span class="sr-only">View</span>
                </th>
            </template>
            <tr v-for="notification in notifications" :key="notification.id">
                <TableRowCol visible="relative" class="font-medium text-gray-900">
                    <template #cell>
                        <div class="flex items-center justify-end gap-x-2 sm:justify-start">
                            <div :class="[notification.read_at == null ? 'text-rose-400 bg-rose-400/10': 'text-gray-400 bg-gray-400/10', 'flex-none rounded-full p-1']">
                                <div class="h-1.5 w-1.5 rounded-full bg-current" />
                            </div>
                        {{ notification.data[notification.display_model_key][notification.display_data_key] }}: {{ notification.display_name }}
                        </div>
                    <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                    <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                    </template>
                </TableRowCol>
                <TableRowCol :value="notification.data.string" />
              <TableRowCol visible="relative" class="font-medium">
                <template #cell>
                    <Link :href="route(notification.model_route_name, notification.data[notification.display_model_key]['id'])" class="text-indigo-600 hover:text-indigo-900">
                        View<span class="sr-only">, {{ notification.data[notification.display_model_key][notification.display_data_key] }}</span>
                    </Link>
                </template>
              </TableRowCol>

            </tr>
        </TableFullwidth>
      </div>
    </div>
</template>
