<script setup>
import { Head } from '@inertiajs/vue3';
import { PlusSmallIcon } from '@heroicons/vue/20/solid';
import { Link } from '@inertiajs/vue3';
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
  } from '@headlessui/vue'
import TableHeadCol from '@/Components/TableHeadCol.vue';
import TableFullwidth from '@/Components/TableFullwidth.vue';
import TableRowCol from '@/Components/TableRowCol.vue';
import { ref } from 'vue';
import CreateNewMemberForm from './Partials/CreateNewMemberForm.vue';
import PageHeading from '@/Components/PageHeading.vue';

defineProps({
    members: Array
})

const filter = ref('all');
</script>

<template>
    <Head title="Research Team" />
    <CreateNewMemberForm ref="CreateNewMemberForm" />

    <PageHeading title="Research Team">
        <template #filters>
            <RadioGroup v-model="filter" class="flex gap-x-8">
                <RadioGroupOption v-slot="{ checked }" value="all" class="cursor-pointer">
                    <span :class="checked ? 'text-indigo-600' : 'text-gray-700'">All</span>
                </RadioGroupOption>
                <RadioGroupOption v-slot="{ checked }" value="mine" class="cursor-pointer">
                    <span :class="checked ? 'text-indigo-600' : 'text-gray-700'">Assigned to me</span>
                </RadioGroupOption>
            </RadioGroup>
        </template>
        <template #actions>
            <button v-if="$authorize('member.create')" @click="$refs.CreateNewMemberForm.openPanel()" class="flex items-center gap-x-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <PlusSmallIcon class="-ml-1.5 h-5 w-5" aria-hidden="true" />
                New Team Member
            </button>
        </template>
    </PageHeading>
    <div class="mt-8 flow-root overflow-hidden">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <TableFullwidth>
            <template #thead>
                <th scope="col" class="relative isolate py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
                    Name
                    <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-b-gray-200" />
                    <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-b-gray-200" />
                </th>
                <TableHeadCol>Assignable</TableHeadCol>
                <TableHeadCol>Role</TableHeadCol>
                <th scope="col" class="relative py-3.5 pl-3">
                    <span class="sr-only">Edit</span>
                </th>
            </template>

            <tr v-for="member in members" :key="member.id">
                <TableRowCol visible="relative" class="font-medium text-gray-900">
                    <template #cell>
                        <div class="font-medium text-gray-900">{{ member.name }}</div>
                      <div class="mt-1 text-gray-500">{{ member.email_address }}</div>
                    <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                    <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                    </template>
                </TableRowCol>
                <TableRowCol :value="member.is_assignable">
                <template #cell>
                    <div class="flex items-center justify-end gap-x-2 sm:justify-start">
                    <div :class="[member.is_assignable ? 'text-green-400 bg-green-400/10': 'text-rose-400 bg-rose-400/10', 'flex-none rounded-full p-1']">
                        <div class="h-1.5 w-1.5 rounded-full bg-current" />
                    </div>
                    <div class="hidden sm:block">{{ member.is_assignable ? 'Assignable' : 'Not Assignable' }}</div>
                    </div>
                </template>
              </TableRowCol>
              <TableRowCol>
                <template #cell>
                    <template v-for="role in member.user_roles" as="span">
                        {{ role }}
                    </template>
                </template>
              </TableRowCol>

              <TableRowCol visible="relative" class="font-medium">
                <template #cell>
                    <Link :href="route('member.show', member)" class="text-indigo-600 hover:text-indigo-900">
                        View<span class="sr-only">, {{ member.name }}</span>
                    </Link>
                </template>
              </TableRowCol>
            </tr>
        </TableFullwidth>
      </div>
    </div>
</template>
