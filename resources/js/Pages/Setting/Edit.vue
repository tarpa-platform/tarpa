<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import PageHeading from '@/Components/PageHeading.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { Switch } from '@headlessui/vue'
import { ref } from 'vue'

const props = defineProps({
    settings: {
        type: Array,
        required: true
    },
    timezones: {
        type: Array,
        required: true
    }
})

const editing = ref({
    study_name: false,
    longitudinal: false,
    timezone: false
})

const form = useForm({
    study_name: props.settings.study_name,
    longitudinal: props.settings.longitudinal,
    timezone: props.timezones.find((tz) => tz.value === props.settings.timezone)
})
</script>

<template>
    <Head title="Application Settings" />
    <PageHeading title="Application Settings" />
    <div class="mt-8 flow-root overflow-hidden">
      <div class="mx-auto max-w-7xl space-y-16 sm:space-y-20">
    <div>
          <h2 class="px-4 sm:px-6 lg:px-8 text-base font-semibold leading-7 text-gray-900">Background</h2>
          <dl class="mt-6 space-y-6 divide-y divide-gray-100 border-t border-gray-200 text-sm leading-6">
            <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Study name</dt>
              <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <div class="text-gray-900" v-if="!editing.study_name">{{ settings.study_name }}</div>
                <TextInput type="text" v-if="editing.study_name" v-model="form.study_name" class="block w-full"></TextInput>
                <InputError class="mt-2" :message="form.errors.name" />
                <div class="inline-flex justify-between items-center">
                    <button v-if="!editing.study_name" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.study_name = true">Update</button>
                    <button v-if="editing.study_name" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.transform((data) => ({...data, timezone: data.timezone.value})).patch(route('setting.update'), {onSuccess: ()=>{editing.study_name = false}})">Save</button>
                    <button v-if="editing.study_name" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.study_name = false">Cancel</button>
                </div>
            </dd>
            </div>
            <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
                <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Longitudinal study</dt>
                <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                    <Switch :disabled="!editing.longitudinal" v-model="form.longitudinal" :class="[editing.longitudinal ? 'cursor-pointer': 'opacity-50', form.longitudinal ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2']">
                        <span class="sr-only">Use setting</span>
                        <span :class="[form.longitudinal ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
                        <span :class="[form.longitudinal ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
                            <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                            <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span :class="[form.longitudinal ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
                            <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                            <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                            </svg>
                        </span>
                        </span>
                    </Switch>
                <div class="inline-flex justify-between items-center">
                    <button v-if="!editing.longitudinal" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.longitudinal = true">Update</button>
                    <button v-if="editing.longitudinal" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.transform((data) => ({...data, timezone: data.timezone.value})).patch(route('setting.update'), {onSuccess: ()=>{editing.longitudinal = false}})">Save</button>
                    <button v-if="editing.longitudinal" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.longitudinal = false">Cancel</button>
                </div>
            </dd>
            </div>
            <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Default timezone</dt>
              <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <div class="text-gray-900" v-if="!editing.timezone">{{ form.timezone.display }}</div>
                <select v-if="editing.timezone" v-model="form.timezone" class="block w-full  rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option v-for="timezone in timezones" :value="timezone">
                        {{ timezone.display }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.timezone" />
                <div class="inline-flex justify-between items-center">
                    <button v-if="!editing.timezone" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.timezone = true">Update</button>
                    <button v-if="editing.timezone" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.transform((data) => ({...data, timezone: data.timezone.value})).patch(route('setting.update'), {onSuccess: ()=>{editing.timezone = false}})">Save</button>
                    <button v-if="editing.timezone" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.timezone = false">Cancel</button>
                </div>
              </dd>
            </div>

            <!--
            <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Email address</dt>
              <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <div class="text-gray-900" v-if="!editing.email_address">{{ member.email_address }}</div>
                <TextInput type="text" v-if="editing.email_address" v-model="form.email_address" class="block w-full"></TextInput>
                <InputError class="mt-2" :message="form.errors.email_address" />
                <div class="inline-flex justify-between items-center" v-if="!member.deleted_at">
                    <button v-if="!editing.email_address" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.email_address = true">Update</button>
                    <button v-if="editing.email_address" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('member.update', member), {onSuccess: ()=>{editing.email_address = false}})">Save</button>
                    <button v-if="editing.email_address" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="editing.email_address = false">Cancel</button>
                </div>
              </dd>
            </div>
            <div class="pt-6 sm:flex px-4 sm:px-6 lg:px-8">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Role</dt>
              <dd v-if="member.user_roles.length > 0" class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <template v-for="role in member.user_roles" as="div" class="text-gray-900">
                    {{ role }}
                </template>
                <button type="button" class="font-semibold text-indigo-600 hover:text-indigo-500">Update</button>
              </dd>
            </div>
        -->
          </dl>
        </div>
        <!--
        <div class="">
          <h2 class="px-4 sm:px-6 lg:px-8 text-base font-semibold leading-7 text-gray-900">Actions</h2>
          <div class="px-4 sm:px-6 lg:px-8 mt-6 space-y-6 divide-y divide-gray-100 border-t border-gray-200 text-sm leading-6">
            <Link :href="route('member.delete', member)" method="delete" v-if="$authorize('member.delete') && !member.deleted_at">
                <DangerButton class="mt-8" >Delete Team Member</DangerButton>
            </Link>
            <Link :href="route('member.restore', member)" method="patch" v-if="$authorize('member.restore') && member.deleted_at">
                <PrimaryButton class="mt-8">Restore Team Member</PrimaryButton>
            </Link>
          </div>
          </div>
          -->
        </div>

        </div>
</template>
