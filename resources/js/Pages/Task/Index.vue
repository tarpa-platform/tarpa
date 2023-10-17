<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, reactive, watch } from 'vue';
import { throttle, pickBy, join, flatMap } from 'lodash';
import PageHeading from '@/Components/PageHeading.vue';
import { PlusSmallIcon } from '@heroicons/vue/24/outline';
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
  } from '@headlessui/vue'

defineProps({
    tasks: {
        type: Array,
        required: true
    }
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
    //router.get(route("participant.index"), {filter: filters, sort: sort_string}, { preserveState: true });
  }, 300),
  { deep: true }
);

</script>

<template>
    <Head title="Tasks" />
    <PageHeading title="Tasks">
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
            <button v-if="$authorize('task.create')" class="ml-auto flex items-center gap-x-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <PlusSmallIcon class="-ml-1.5 h-5 w-5" aria-hidden="true" />
                New Task
            </button>
        </template>
    </PageHeading>
    <pre>
    {{ tasks }}
</pre>
</template>
