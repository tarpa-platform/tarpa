<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { PlusSmallIcon } from '@heroicons/vue/20/solid';
import PageHeading from '@/Components/PageHeading.vue';
import TableHeadCol from '@/Components/TableHeadCol.vue';
import TableFullwidth from '@/Components/TableFullwidth.vue';
import TableRowCol from '@/Components/TableRowCol.vue';
import CreateNewTimepointForm from './Partials/CreateNewTimepointForm.vue'
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
  } from '@headlessui/vue'

defineProps({
    timepoints: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <Head title="Participant Timepoints" />
    <CreateNewTimepointForm ref="CreateNewTimepointForm" />
    <PageHeading title="Participant Timepoints">
        <template #actions>
            <button v-if="$authorize('timepoint.create')" @click="$refs.CreateNewTimepointForm.openPanel()" class="ml-auto flex items-center gap-x-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <PlusSmallIcon class="-ml-1.5 h-5 w-5" aria-hidden="true" />
                New Timepoint
            </button>
        </template>
    </PageHeading>
    <div class="mt-8 flow-root overflow-hidden">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <TableFullwidth>
            <template #thead>
                <th scope="col" class="relative isolate py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
                    Description
                    <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-b-gray-200" />
                    <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-b-gray-200" />
                </th>
                <TableHeadCol>Offset (days)</TableHeadCol>
                <th scope="col" class="relative py-3.5 pl-3">
                    <span class="sr-only">View</span>
                </th>
            </template>

            <tr v-for="timepoint in timepoints" :key="timepoint.id">
                <TableRowCol visible="relative" class="font-medium text-gray-900">
                    <template #cell>
                        {{ timepoint.description }}
                    <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                    <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                    </template>
                </TableRowCol>
                <TableRowCol :value="timepoint.offset"></TableRowCol>

              <TableRowCol visible="relative" class="font-medium">
                <template #cell>
                    <Link :href="route('timepoint.show', timepoint)" class="text-indigo-600 hover:text-indigo-900">
                        View<span class="sr-only">, {{ timepoint.description }}</span>
                    </Link>
                </template>
              </TableRowCol>
            </tr>
        </TableFullwidth>
      </div>
    </div>

</template>
