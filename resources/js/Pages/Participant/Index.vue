<script setup>
import { throttle, pickBy, join, flatMap } from 'lodash';
import { Head, router } from '@inertiajs/vue3';
import { PlusSmallIcon, ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/20/solid';
import { Link } from '@inertiajs/vue3';
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
  } from '@headlessui/vue'
import TableHeadCol from '@/Components/TableHeadCol.vue';
import TableFullwidth from '@/Components/TableFullwidth.vue';
import TableRowCol from '@/Components/TableRowCol.vue';
import PageHeading from '@/Components/PageHeading.vue';
import { ref, watch, reactive } from 'vue';
import CreateNewParticipantForm from './Partials/CreateNewParticipantForm.vue';

defineProps({
    participants: Array
})

const filters = reactive({
    mine: null
})

const sorts = ref(['-id'])

const query = reactive({
    filter: {
        mine: null
    },
    sort: {
        id: '-'
    }
})

watch(
  () => query,
  throttle(() => {
    const sort_string = join(flatMap(query.sort, (key, value) => {return key + value}), ',')
    console.log(sort_string)
    const filters = pickBy(query.filter)
    router.get(route("participant.index"), {filter: filters, sort: sort_string}, { preserveState: true });
  }, 300),
  { deep: true }
);



</script>

<template>
    <Head title="Participants" />
    <CreateNewParticipantForm ref="CreateNewParticipantForm" />
    <PageHeading title="Participants">
        <template #filters>
            <RadioGroup v-model="query.filter.mine" class="flex gap-x-8">
                <RadioGroupOption v-slot="{ checked }" :value="null" class="cursor-pointer">
                    <span :class="checked ? 'text-indigo-600' : 'text-gray-700'">All</span>
                </RadioGroupOption>
                <RadioGroupOption v-slot="{ checked }" value="1" class="cursor-pointer">
                    <span :class="checked ? 'text-indigo-600' : 'text-gray-700'">Assigned to me</span>
                </RadioGroupOption>
            </RadioGroup>
        </template>
        <template #actions>
            <button @click="$refs.CreateNewParticipantForm.openPanel()" v-if="$authorize('participant.create')" class="ml-auto flex items-center gap-x-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <PlusSmallIcon class="-ml-1.5 h-5 w-5" aria-hidden="true" />
                New Participant
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
                <TableHeadCol>
                    <a href="#" class="group inline-flex">
                    Study ID
                    <span class="ml-2 flex-none rounded text-gray-400">
                      <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </a>
                </TableHeadCol>
                <TableHeadCol>Assigned to</TableHeadCol>
                <TableHeadCol>Status</TableHeadCol>
                <th scope="col" class="relative py-3.5 pl-3">
                    <span class="sr-only">Edit</span>
                </th>
            </template>

            <tr v-for="participant in participants" :key="participant.id">
                <TableRowCol visible="relative" class="font-medium text-gray-900">
                    <template #cell>
                        <!---->
                      <div class="font-medium text-gray-900">{{ participant.name }}</div>
                      <div class="mt-1 text-gray-500">{{ participant.email_address }}</div>

                        <!---->
                    <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                    <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                    </template>
                </TableRowCol>
              <TableRowCol :value="participant.canonical_id" />
              <TableRowCol :value="participant.member ? participant.member.name : 'Not assigned'"></TableRowCol>
              <TableRowCol :value="participant.status.description">
                <template #cell>
                    <div class="flex items-center justify-end gap-x-2 sm:justify-start">
                    <div :class="[participant.status.is_active ? 'text-green-400 bg-green-400/10': 'text-rose-400 bg-rose-400/10', 'flex-none rounded-full p-1']">
                        <div class="h-1.5 w-1.5 rounded-full bg-current" />
                    </div>
                    <div class="hidden sm:block">{{ participant.status.description }}{{ ($feature('longitudinal' && participant.timepoint != null) ? ' (' + participant.timepoint.description + ')' : '') }}</div>
                    </div>
                </template>
            </TableRowCol>
              <TableRowCol visible="relative" class="font-medium">
                <template #cell>
                    <Link :href="route('participant.show', participant)" class="text-indigo-600 hover:text-indigo-900">
                        View<span class="sr-only">, {{ participant.name }}</span>
                    </Link>
                </template>
              </TableRowCol>
            </tr>
        </TableFullwidth>
      </div>
    </div>
</template>
