<script setup>
import { Head, Link } from '@inertiajs/vue3';
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

defineProps({
    archives: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <Head title="Recently Deleted" />
    <PageHeading title="Recently Deleted">
        <template #actions>
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
                <TableHeadCol>Type</TableHeadCol>
                <th scope="col" class="relative py-3.5 pl-3">
                    <span class="sr-only">View</span>
                </th>
            </template>

            <tr v-for="archive in archives" :key="archive.id">
                <TableRowCol visible="relative" class="font-medium text-gray-900">
                    <template #cell>
                        {{ archive.archivable[archive.model_key] }}
                    <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                    <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                    </template>
                </TableRowCol>
                <TableRowCol :value="archive.model_name"></TableRowCol>

              <TableRowCol visible="relative" class="font-medium">
                <template #cell>
                    <Link :href="route('archive.show', archive)" class="text-indigo-600 hover:text-indigo-900">
                        View<span class="sr-only">, {{ archive.archivable[archive.model_key] }}</span>
                    </Link>
                </template>
              </TableRowCol>
            </tr>
        </TableFullwidth>
      </div>
    </div>

</template>
