<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { PlusSmallIcon } from '@heroicons/vue/20/solid';
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
  } from '@headlessui/vue'
import TableHeadCol from '@/Components/TableHeadCol.vue';
import TableFullwidth from '@/Components/TableFullwidth.vue';
import TableRowCol from '@/Components/TableRowCol.vue';
defineProps({
    roles: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <Head title="Roles & Permissions" />
            <div class="flex flex-wrap items-center gap-6 sm:flex-nowrap px-4 sm:px-6 lg:px-8">
                <h1 class="text-base font-semibold leading-7 text-gray-900">Study Roles</h1>
                <!--
                <RadioGroup v-model="filter" class="order-last flex w-full gap-x-8 text-sm font-semibold leading-6 sm:order-none sm:w-auto sm:border-l sm:border-gray-200 sm:pl-6 sm:leading-7">
                    <RadioGroupOption v-slot="{ checked }" value="all" class="cursor-pointer">
                        <span :class="checked ? 'text-indigo-600' : 'text-gray-700'">All</span>
                    </RadioGroupOption>
                    <RadioGroupOption v-slot="{ checked }" value="mine" class="cursor-pointer">
                        <span :class="checked ? 'text-indigo-600' : 'text-gray-700'">Assigned to me</span>
                    </RadioGroupOption>
                </RadioGroup>
                -->
                <Link as="button" :href="route('role.create')" class="ml-auto flex items-center gap-x-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <PlusSmallIcon class="-ml-1.5 h-5 w-5" aria-hidden="true" />
                    New Role
                </Link>
            </div>

            <div class="mt-8 flow-root overflow-hidden">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <TableFullwidth>
            <template #thead>
                <th scope="col" class="relative isolate py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
                    Role
                    <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-b-gray-200" />
                    <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-b-gray-200" />
                </th>
                <TableHeadCol>Description</TableHeadCol>
                <th scope="col" class="relative py-3.5 pl-3">
                    <span class="sr-only">Edit</span>
                </th>
            </template>

            <tr v-for="role in roles" :key="role.id">
                <TableRowCol visible="relative" class="font-medium text-gray-900">
                    <template #cell>
                        {{ role.name }}
                    <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                    <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                    </template>
                </TableRowCol>
              <TableRowCol :value="role.description" />
              <TableRowCol visible="relative" class="font-medium">
                <template #cell>
                    <Link :href="route('role.show', role)" class="text-indigo-600 hover:text-indigo-900">
                        Edit<span class="sr-only">, {{ role.name }}</span>
                    </Link>
                </template>
              </TableRowCol>
            </tr>
        </TableFullwidth>
      </div>
    </div>
</template>
