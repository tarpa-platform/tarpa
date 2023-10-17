<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import PageHeading from '@/Components/PageHeading.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    member: {
        type: Object,
        required: true
    }
})

const editing = ref({
    name: false,
    email_address: false,
    is_assignable: false
})

const form = useForm({
    name: props.member.name,
    email_address: props.member.email_address,
    is_assignable: props.member.is_assignable
})
</script>

<template>
    <Head :title="member.name" />
    <PageHeading :title="member.name" />
    <div class="mt-8 flow-root overflow-hidden">
      <div class="mx-auto max-w-7xl space-y-16 sm:space-y-20">
    <div>
          <h2 class="px-4 sm:px-6 lg:px-8 text-base font-semibold leading-7 text-gray-900">Profile</h2>
          <dl class="mt-6 space-y-6 divide-y divide-gray-100 border-t border-gray-200 text-sm leading-6">
            <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Full name</dt>
              <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <div class="text-gray-900" v-if="!editing.name">{{ member.name }}</div>
                <TextInput type="text" v-if="editing.name" v-model="form.name" class="block w-full"></TextInput>
                <InputError class="mt-2" :message="form.errors.name" />
                <div class="inline-flex justify-between items-center" v-if="!member.deleted_at">
                    <button v-if="!editing.name" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.name = true">Update</button>
                    <button v-if="editing.name" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('member.update', member), {onSuccess: ()=>{editing.name = false}})">Save</button>
                    <button v-if="editing.name" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.name = false">Cancel</button>
                </div>
            </dd>
            </div>
            <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Email address</dt>
              <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <div class="text-gray-900" v-if="!editing.email_address">{{ member.email_address }}</div>
                <TextInput type="text" v-if="editing.email_address" v-model="form.email_address" class="block w-full"></TextInput>
                <InputError class="mt-2" :message="form.errors.email_address" />
                <div class="inline-flex justify-between items-center" v-if="!member.deleted_at">
                    <button v-if="!editing.email_address" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.email_address = true">Update</button>
                    <button v-if="editing.email_address" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('member.update', member), {onSuccess: ()=>{editing.email_address = false}})">Save</button>
                    <button v-if="editing.email_address" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.email_address = false">Cancel</button>
                </div>
              </dd>
            </div>
            <div class="pt-6 sm:flex items-center px-4 sm:px-6 lg:px-8">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Assignable to participants</dt>
              <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <!--<div class="text-gray-900" v-if="!editing.is_assignable">{{ member.is_assignable }}</div>-->
                <div class="flex items-center justify-end gap-x-2 sm:justify-start" v-if="!editing.is_assignable">
                    <div :class="[member.is_assignable ? 'text-green-400 bg-green-400/10': 'text-rose-400 bg-rose-400/10', 'flex-none rounded-full p-1']">
                        <div class="h-1.5 w-1.5 rounded-full bg-current" />
                    </div>
                    <div class="hidden sm:block">{{ member.is_assignable ? 'Assignable' : 'Not Assignable' }}</div>
                    </div>
                <select v-if="editing.is_assignable" v-model="form.is_assignable" class="block w-full  rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option value="0">
                        Not assignable
                    </option>
                    <option value="1">
                        Assignable
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.is_assignable" />
                <div class="inline-flex justify-between items-center" v-if="!member.deleted_at">
                    <button v-if="!editing.is_assignable" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500" @click="editing.is_assignable = true">Update</button>
                    <button v-if="editing.is_assignable" type="button" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-3" @click="form.patch(route('member.update', member), {onSuccess: ()=>{editing.is_assignable = false}})">Save</button>
                    <button v-if="editing.is_assignable" type="button" class="font-semibold text-gray-600 hover:text-gray-500" @click="form.reset(); editing.is_assignable = false">Cancel</button>
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
          </dl>
        </div>
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
        </div>
        </div>
</template>
