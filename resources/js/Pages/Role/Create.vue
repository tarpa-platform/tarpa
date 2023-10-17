<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import PageHeading from '@/Components/PageHeading.vue';
import TextInput from '@/Components/TextInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TableFullwidth from '@/Components/TableFullwidth.vue';
import TableHeadCol from '@/Components/TableHeadCol.vue';
import TableRowCol from '@/Components/TableRowCol.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const resources = [
    {
        name: 'Team Members',
        key: 'member'
    },
    {
        name: 'Participants',
        key: 'participant'
    },
    {
        name: 'Calendar Events',
        key: 'event'
    },
    {
        name: 'Tasks',
        key: 'task'
    },
    {
        name: 'Notes',
        key: 'note'
    },
    {
        name: 'Time Points',
        key: 'timepoint'
    },
    {
        name: 'Statuses',
        key: 'status'
    },
    {
        name: 'Calendar Event Templates',
        key: 'eventtemplate'
    },
    {
        name: 'Task Templates',
        key: 'tasktemplate'
    }
]
const permissions = ['view', 'create', 'update', 'delete', 'restore']
const adminResources = [
    {
        name: 'View Activity Log',
        key: 'activitylog.view'
    },
    {
        name: 'Impersonate User',
        key: 'user.impersonate'
    },
    {
        name: 'Manage Roles and Permissions',
        key: 'roles.manage'
    },
    {
        name: 'Manage Application Settings',
        key: 'settings.manage'
    }
]
const selectedPermissions = ref([])
const form = useForm({
    name: '',
    description: ''
})
</script>

<template>
    <Head title="Create New Role" />

    <PageHeading title="Create New Role" />

    <div class="max-w-xl px-4 sm:px-6 lg:px-8 mt-8 space-y-6">
        <div>
            <InputLabel for="name" value="Role Name" />
            <TextInput
                type="text"
                v-model="form.name"
                id="name"
                class="mt-1 block w-full"
                autofocus
                required
            />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div>
            <InputLabel for="description" value="Description" />
            <TextareaInput
                v-model="form.description"
                id="description"
                class="mt-1 block w-full"
                required
            />
            <InputError class="mt-2" :message="form.errors.description" />
        </div>
    </div>

    <div class="mt-8 flow-root overflow-hidden">
        <InputLabel class="sr-only" for="resource-permissions" value="Resource Permissions" />
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <TableFullwidth id="resource-permissions">
                <template #thead>
                    <th scope="col" class="relative isolate py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
                        Resource Permissions
                        <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-b-gray-200" />
                        <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-b-gray-200" />
                    </th>
                    <template v-for="permission in permissions">
                        <TableHeadCol class="capitalize text-center">{{ permission }}</TableHeadCol>
                    </template>
                </template>
                <tr v-for="resource in resources" :key="resource.key">
                    <TableRowCol visible="relative" class="font-medium text-gray-900 capitalize">
                        <template #cell>
                            {{ resource.name }}
                        <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                        <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                        </template>
                    </TableRowCol>
                    <template v-for="permission in permissions">
                        <TableRowCol visible="relative whitespace-nowrap">
                            <template #cell>
                                <span class="sr-only">New role can {{ permission }} {{ resource.name }}.</span>
                                <input type="checkbox" class="-mt-2 mx-auto block h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" :value="resource.key + '.' + permission" v-model="selectedPermissions" />
                            </template>
                        </TableRowCol>
                    </template>
                </tr>
            </TableFullwidth>

            <h2 class="text-sm font-semibold leading-7 text-gray-900 mt-8">Administrative Permissions</h2>
            <template v-for="resource in adminResources">
                <div class="mt-2 relative flex items-start">
                    <div class="flex h-6 items-center">
                <input :id="resource.key + '-input'" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" :value="resource.key" v-model="selectedPermissions" />
                    </div>
                    <div class="ml-3 text-sm leading-6">
                    <label :for="resource.key + '-input'" class="font-medium text-gray-900"><span class="sr-only">New role can </span>{{ resource.name }}</label>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <PrimaryButton @click.prevent="form.transform((data) => ({...data, permissions: selectedPermissions})).post(route('role.store'))">
    Save
    </PrimaryButton>

<!--
            <table id="permissions" class="min-w-full divide-y divide-gray-300 border-b-gray-300 border-b">
              <thead>
                <tr>
                  <th scope="col" class="min-w-[12rem] px-4 sm:px-6 lg:px-8 py-3.5 text-left text-sm font-semibold text-gray-900">Resource Permissions</th>
                  <th v-for="permission in permissions" scope="col" class="px-3 py-3.5 text-center capitalize text-sm font-semibold text-gray-900">{{ permission }}</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="resource in resources" :key="resource.key" :class="[selectedPermissions.includes(resource.key) && 'bg-gray-50']">
                  <td :class="['whitespace-nowrap px-4 sm:px-6 lg:px-8 py-4 text-sm font-medium', selectedPermissions.includes(resource.key) ? 'text-indigo-600' : 'text-gray-900']">
                    {{ resource.name }}
                  </td>
                  <template v-for="permission in permissions">
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <span class="sr-only">New role can {{ permission }} {{ resource.name }}.</span>
                        <input type="checkbox" class="-mt-2 mx-auto block h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" :value="resource.key + '.' + permission" v-model="selectedPermissions" />
                    </td>
                    </template>
                </tr>
              </tbody>
            </table>
          </div>
          </div>
          <h2 class="px-4 sm:px-6 lg:px-8 text-sm font-semibold leading-7 text-gray-900 mt-8">Administrative Permissions</h2>
    <template v-for="resource in adminResources">
        <div class="max-w-xl px-4 sm:px-6 lg:px-8 mt-2 relative flex items-start">
            <div class="flex h-6 items-center">
          <input :id="resource.key + '-input'" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" :value="resource.key" v-model="selectedPermissions" />
            </div>
            <div class="ml-3 text-sm leading-6">
            <label :for="resource.key + '-input'" class="font-medium text-gray-900"><span class="sr-only">New role can </span>{{ resource.name }}</label>
            </div>
        </div>
    </template>
    -->

</template>
