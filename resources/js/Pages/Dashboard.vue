<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowDownIcon, ArrowUpIcon } from '@heroicons/vue/20/solid'
import { ClipboardDocumentCheckIcon, CalendarIcon, UsersIcon } from '@heroicons/vue/24/outline'
import PageHeading from '@/Components/PageHeading.vue';
import { ref, computed } from 'vue';
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
  } from '@headlessui/vue'
import vue from '@heroicons/vue';

const props = defineProps({
    stats: {
        type: Array,
        required: true
    }
})

const statIcons = {
    'participant': UsersIcon,
    'event': CalendarIcon,
    'task': ClipboardDocumentCheckIcon
}

const filteredStats = computed(() => {
    return props.stats.filter(e => e.type == filter.value)
})

const filter = ref('mine')

</script>

<template>
    <Head title="Dashboard" />
    <PageHeading title="Dashboard">
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
    </PageHeading>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <dl class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <div v-for="item in filteredStats" :key="item.id" class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
        <dt>
          <div class="absolute rounded-md bg-indigo-500 p-3">
            <component :is="statIcons[item.model]" class="h-6 w-6 text-white" aria-hidden="true" />
          </div>
          <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ item.name }}</p>
        </dt>
        <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
          <p class="text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
          <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
              <Link :href="item.url" class="font-medium text-indigo-600 hover:text-indigo-500"
                >View all<span class="sr-only"> {{ item.name }} stats</span></Link
              >
            </div>
          </div>
        </dd>
      </div>
    </dl>
  </div>
</template>
