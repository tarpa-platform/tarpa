<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import PageHeading from '@/Components/PageHeading.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { PlusSmallIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    participant: {
        type: Object,
        required: true
    },
    statuses: {
        type: Array,
        required: true
    },
    timepoints: {
        type: Array,
        required: false
    },
    members: {
        type: Array,
        required: true
    }
})

const editing = ref({
    name: false,
    canonical_id: false,
    email_address: false,
    status_id: false,
    member_id: false,
    timepoint_id: false
})

const form = useForm({
    name: props.participant.name,
    canonical_id: props.participant.canonical_id,
    email_address: props.participant.email_address,
    status_id: props.participant.status_id,
    member_id: props.participant.member_id,
    timepoint_id: props.participant.timepoint_id
})
</script>

<template>
    <Head :title="participant.canonical_id" />
    <PageHeading :title="participant.canonical_id + ' – ' + participant.name">
        <template #actions>
            <button v-if="$authorize('event.create')" class="ml-auto flex items-center gap-x-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <PlusSmallIcon class="-ml-1.5 h-5 w-5" aria-hidden="true" />
                New Event
            </button>
            <button v-if="$authorize('task.create')" class="ml-auto flex items-center gap-x-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <PlusSmallIcon class="-ml-1.5 h-5 w-5" aria-hidden="true" />
                New Task
            </button>
        </template>
    </PageHeading>
    <div class="mt-8 flow-root overflow-hidden">
        <div class="mx-auto max-w-7xl space-y-16 sm:space-y-20">
            <div>
                <h2 class="px-4 sm:px-6 lg:px-8 text-base font-semibold leading-7 text-gray-900">Profile</h2>
                <dl class="mt-6 space-y-6 divide-y divide-gray-100 border-t border-gray-200 text-sm leading-6">
                    <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Full name</dt>
                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                            <div class="text-gray-900" v-if="!editing.name">{{ participant.name }}</div>
                            <div class="block w-full" v-if="editing.name">
                                <TextInput type="text" v-model="form.name" class="block w-full"></TextInput>
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div class="inline-flex justify-between items-center" v-if="!participant.deleted_at">
                                <button v-if="!editing.name" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.name = true">Update</button>
                                <button v-if="editing.name" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('participant.update', participant), {onSuccess: ()=>{editing.name = false}})">Save</button>
                                <button v-if="editing.name" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.name = false">Cancel</button>
                            </div>
                        </dd>
                    </div>
                    <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Email address</dt>
                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                            <div class="text-gray-900" v-if="!editing.email_address">{{ participant.email_address }}</div>
                            <div class="block w-full" v-if="editing.email_address" >
                                <TextInput type="email" v-model="form.email_address" class="block w-full"></TextInput>
                                <InputError class="mt-2" :message="form.errors.email_address" />
                            </div>
                            <div class="inline-flex justify-between items-center" v-if="!participant.deleted_at">
                                <button v-if="!editing.email_address" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.email_address = true">Update</button>
                                <button v-if="editing.email_address" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('participant.update', participant), {onSuccess: ()=>{editing.email_address = false}})">Save</button>
                                <button v-if="editing.email_address" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.email_address = false">Cancel</button>
                            </div>
                        </dd>
                    </div>
                    <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Study ID</dt>
                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                            <div class="text-gray-900" v-if="!editing.canonical_id">{{ participant.canonical_id }}</div>
                            <div class="block w-full" v-if="editing.canonical_id">
                                <TextInput type="text" v-model="form.canonical_id" class="block w-full"></TextInput>
                                <InputError class="mt-2" :message="form.errors.canonical_id" />
                            </div>
                            <div class="inline-flex justify-between items-center" v-if="!participant.deleted_at">
                                <button v-if="!editing.canonical_id" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.canonical_id = true">Update</button>
                                <button v-if="editing.canonical_id" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('participant.update', participant), {onSuccess: ()=>{editing.canonical_id = false}})">Save</button>
                                <button v-if="editing.canonical_id" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.canonical_id = false">Cancel</button>
                            </div>
                        </dd>
                    </div>
                    <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Status</dt>
                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                            <div class="flex items-center justify-end gap-x-2 sm:justify-start" v-if="!editing.status_id">
                                <div :class="[participant.status.is_active ? 'text-green-400 bg-green-400/10': 'text-rose-400 bg-rose-400/10', 'flex-none rounded-full p-1']">
                                    <div class="h-1.5 w-1.5 rounded-full bg-current" />
                                </div>
                                <div class="hidden sm:block">{{ participant.status.description }}</div>
                            </div>
                            <select v-if="editing.status_id" v-model="form.status_id" class="block w-full  rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option v-for="status in statuses" :value="status.id">
                                    {{ status.description }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.status_id" />
                            <div class="inline-flex justify-between items-center" v-if="!participant.deleted_at">
                                <button v-if="!editing.status_id" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.status_id = true">Update</button>
                                <button v-if="editing.status_id" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('participant.update', participant), {onSuccess: ()=>{editing.status_id = false}})">Save</button>
                                <button v-if="editing.status_id" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.status_id = false">Cancel</button>
                            </div>
                        </dd>
                    </div>
                    <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8" v-if="$feature('longitudinal')">
                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Timepoint</dt>
                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                            <div class="flex items-center justify-end gap-x-2 sm:justify-start" v-if="!editing.timepoint_id">
                                <div class="hidden sm:block">{{ (participant.timepoint) ? participant.timepoint.description : '' }}</div>
                            </div>
                            <select v-if="editing.timepoint_id" v-model="form.timepoint_id" class="block w-full  rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option v-for="timepoint in timepoints" :value="timepoint.id">
                                    {{ timepoint.description }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.timepoint_id" />
                            <div class="inline-flex justify-between items-center" v-if="!participant.deleted_at">
                                <button v-if="!editing.timepoint_id" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.timepoint_id = true">Update</button>
                                <button v-if="editing.timepoint_id" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('participant.update', participant), {onSuccess: ()=>{editing.timepoint_id = false}})">Save</button>
                                <button v-if="editing.timepoint_id" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.timepoint_id = false">Cancel</button>
                            </div>
                        </dd>
                    </div>
                    <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
                        <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Assigned to</dt>
                        <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                            <div class="text-gray-900" v-if="!editing.member_id">{{ participant.member ? participant.member.name : 'Not assigned' }}</div>
                            <select v-if="editing.member_id" v-model="form.member_id" class="block w-full  rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option v-for="member in members" :value="member.id">
                                    {{ member.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.member_id" />
                            <div class="inline-flex justify-between items-center" v-if="!participant.deleted_at">
                                <button v-if="!editing.member_id" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.member_id = true">Update</button>
                                <button v-if="editing.member_id" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('participant.update', participant), {onSuccess: ()=>{editing.member_id = false}})">Save</button>
                                <button v-if="editing.member_id" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.member_id = false">Cancel</button>
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
</template>
