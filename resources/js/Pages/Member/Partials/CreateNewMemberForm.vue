<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { RadioGroup, RadioGroupDescription, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { LinkIcon, PlusIcon, QuestionMarkCircleIcon } from '@heroicons/vue/20/solid'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email_address: '',
    is_assignable: {},
    role : {}
})

const assignableOptions = ref([
    { value: 1, name: 'Assignable', description: 'The team member can be assigned to participants as study coordinator.'},
    { value: 0, name: 'Not assignable', description: 'The team member cannot be a study coordinator.'}
])

const roles = ref({})
const nameInput = ref(null)

const loadRoles = async() => {
    roles.value = await axios.get(route('api.role.list')).then( (response) => {
        return response.data
    })
};

loadRoles()

const open = ref(false)

const openPanel = () => { open.value = true }

defineExpose({
    openPanel
})
</script>

<template>
    <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-50" :initialFocus="nameInput" @close="open = false">
      <div class="fixed inset-0" />
      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
            <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
              <DialogPanel class="pointer-events-auto w-screen max-w-md">
                <form class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl">
                  <div class="h-0 flex-1 overflow-y-auto">
                    <div class="bg-indigo-700 px-4 py-6 sm:px-6">
                      <div class="flex items-center justify-between">
                        <DialogTitle class="text-base font-semibold leading-6 text-white">New Team Member</DialogTitle>
                        <div class="ml-3 flex h-7 items-center">
                          <button type="button" class="relative rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="open = false">
                            <span class="absolute -inset-2.5" />
                            <span class="sr-only">Close panel</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                          </button>
                        </div>
                      </div>
                      <div class="mt-1">
                        <p class="text-sm text-indigo-300">Complete the information below to create a new study team member.</p>
                      </div>
                    </div>
                    <div class="flex flex-1 flex-col justify-between">
                      <div class="divide-y divide-gray-200 px-4 sm:px-6">
                        <div class="space-y-6 pb-5 pt-6">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    type="text"
                                    v-model="form.name"
                                    id="name"
                                    class="mt-1 block w-full"
                                    ref="nameInput"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    type="email"
                                    v-model="form.email_address"
                                    id="email"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.email_address" />
                            </div>
                            <div>
                                <fieldset>
                                <legend class="text-sm font-medium leading-6 text-gray-900">Assignable to participants</legend>
                                <RadioGroup v-model="form.is_assignable" class="mt-2">
                                    <RadioGroupLabel class="sr-only">Member assignable selection</RadioGroupLabel>
                                    <div class="-space-y-px rounded-md bg-white">
                                    <RadioGroupOption as="template" v-for="(option, optionIdx) in assignableOptions" :key="option.value" :value="option" v-slot="{ checked, active }">
                                        <div :class="[optionIdx === 0 ? 'rounded-tl-md rounded-tr-md' : '', optionIdx === assignableOptions.length - 1 ? 'rounded-bl-md rounded-br-md' : '', checked ? 'z-10 border-indigo-200 bg-indigo-50' : 'border-gray-200', 'relative flex cursor-pointer border p-4 focus:outline-none']">
                                        <span :class="[checked ? 'bg-indigo-600 border-transparent' : 'bg-white border-gray-300', active ? 'ring-2 ring-offset-2 ring-indigo-600' : '', 'mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded-full border flex items-center justify-center']" aria-hidden="true">
                                            <span class="rounded-full bg-white w-1.5 h-1.5" />
                                        </span>
                                        <span class="ml-3 flex flex-col">
                                            <RadioGroupLabel as="span" :class="[checked ? 'text-indigo-900' : 'text-gray-900', 'block text-sm font-medium capitalize']">{{ option.name }}</RadioGroupLabel>
                                            <RadioGroupDescription as="span" :class="[checked ? 'text-indigo-700' : 'text-gray-500', 'block text-sm']">{{ option.description }}</RadioGroupDescription>
                                        </span>
                                        </div>
                                    </RadioGroupOption>
                                    </div>
                                </RadioGroup>
                                <InputError class="mt-2" :message="form.errors.is_assignable" />
                                </fieldset>
                            </div>
                            <div>
                                <fieldset>
                                <legend class="text-sm font-medium leading-6 text-gray-900">User role</legend>
                                <RadioGroup v-model="form.role" class="mt-2">
                                    <RadioGroupLabel class="sr-only">Role selection</RadioGroupLabel>
                                    <div class="-space-y-px rounded-md bg-white">
                                    <RadioGroupOption as="template" v-for="(role, roleIdx) in roles" :key="role.id" :value="role" v-slot="{ checked, active }">
                                        <div :class="[roleIdx === 0 ? 'rounded-tl-md rounded-tr-md' : '', roleIdx === roles.length - 1 ? 'rounded-bl-md rounded-br-md' : '', checked ? 'z-10 border-indigo-200 bg-indigo-50' : 'border-gray-200', 'relative flex cursor-pointer border p-4 focus:outline-none']">
                                        <span :class="[checked ? 'bg-indigo-600 border-transparent' : 'bg-white border-gray-300', active ? 'ring-2 ring-offset-2 ring-indigo-600' : '', 'mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded-full border flex items-center justify-center']" aria-hidden="true">
                                            <span class="rounded-full bg-white w-1.5 h-1.5" />
                                        </span>
                                        <span class="ml-3 flex flex-col">
                                            <RadioGroupLabel as="span" :class="[checked ? 'text-indigo-900' : 'text-gray-900', 'block text-sm font-medium capitalize']">{{ role.name }}</RadioGroupLabel>
                                            <RadioGroupDescription as="span" :class="[checked ? 'text-indigo-700' : 'text-gray-500', 'block text-sm']">{{ role.description }}</RadioGroupDescription>
                                        </span>
                                        </div>
                                    </RadioGroupOption>
                                    </div>
                                </RadioGroup>
                                <InputError class="mt-2" :message="form.errors.role" />
                                </fieldset>
                            </div>

                        </div>
                        <!-- Disclosures
                        <div class="pb-6 pt-4">
                          <div class="flex text-sm">
                            <a href="#" class="group inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                              <LinkIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-900" aria-hidden="true" />
                              <span class="ml-2">Copy link</span>
                            </a>
                          </div>
                          <div class="mt-4 flex text-sm">
                            <a href="#" class="group inline-flex items-center text-gray-500 hover:text-gray-900">
                              <QuestionMarkCircleIcon class="h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                              <span class="ml-2">Learn more about sharing</span>
                            </a>
                          </div>
                        </div>
                         -->
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-shrink-0 justify-end px-4 py-4">
                    <button type="button" @click="open = false; form.reset(); form.clearErrors()" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</button>
                    <button type="submit" @click.prevent="form.transform((data) => ({...data, is_assignable: data.is_assignable.value, role: data.role.name})).post(route('member.store'), {onSuccess: () => { open = false }})" class="ml-4 inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                  </div>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
    <!--
    <TransitionRoot :show="open">
      <Dialog as="div" :initialFocus="nameInput" class="relative z-50" @close="open = false">
        <div class="fixed inset-0" />
        <div class="fixed inset-0 overflow-hidden">
          <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
              <TransitionChild enter="transform transition duration-700 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
                <DialogPanel class="pointer-events-auto w-screen max-w-md">
                  <form class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl">
                    <div class="h-0 flex-1 overflow-y-scroll">
                      <div class="bg-indigo-700 px-4 py-6 sm:px-6">
                        <div class="flex items-center justify-between">
                          <DialogTitle class="text-base font-semibold leading-6 text-white">New Team Member</DialogTitle>
                          <div class="ml-3 flex h-7 items-center">
                            <button type="button" class="rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="open = false">
                              <span class="sr-only">Close panel</span>
                              <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                            </button>
                          </div>
                        </div>
                        <div class="mt-1">
                          <p class="text-sm text-indigo-300">Complete the information below to create a new study team member.</p>
                        </div>
                      </div>
                      <div class="flex flex-1 flex-col justify-between">
                        <div class="divide-y divide-gray-200 px-4 sm:px-6">
                          <div class="space-y-6 pb-5 pt-6">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    type="text"
                                    v-model="form.name"
                                    id="name"
                                    class="mt-1 block w-full"
                                    ref="nameInput"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    type="email"
                                    v-model="form.email_address"
                                    id="email"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.email_address" />
                            </div>
                            <div>
                                <fieldset>
                              <legend class="text-sm font-medium leading-6 text-gray-900">Assignable to participants</legend>
                              <RadioGroup v-model="form.is_assignable" class="mt-2">
                                <RadioGroupLabel class="sr-only">Member assignable selection</RadioGroupLabel>
                                <div class="-space-y-px rounded-md bg-white">
                                <RadioGroupOption as="template" v-for="(option, optionIdx) in assignableOptions" :key="option.value" :value="option" v-slot="{ checked, active }">
                                    <div :class="[optionIdx === 0 ? 'rounded-tl-md rounded-tr-md' : '', optionIdx === assignableOptions.length - 1 ? 'rounded-bl-md rounded-br-md' : '', checked ? 'z-10 border-indigo-200 bg-indigo-50' : 'border-gray-200', 'relative flex cursor-pointer border p-4 focus:outline-none']">
                                    <span :class="[checked ? 'bg-indigo-600 border-transparent' : 'bg-white border-gray-300', active ? 'ring-2 ring-offset-2 ring-indigo-600' : '', 'mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded-full border flex items-center justify-center']" aria-hidden="true">
                                        <span class="rounded-full bg-white w-1.5 h-1.5" />
                                    </span>
                                    <span class="ml-3 flex flex-col">
                                        <RadioGroupLabel as="span" :class="[checked ? 'text-indigo-900' : 'text-gray-900', 'block text-sm font-medium capitalize']">{{ option.name }}</RadioGroupLabel>
                                        <RadioGroupDescription as="span" :class="[checked ? 'text-indigo-700' : 'text-gray-500', 'block text-sm']">{{ option.description }}</RadioGroupDescription>
                                    </span>
                                    </div>
                                </RadioGroupOption>
                                </div>
                            </RadioGroup>
                            <InputError class="mt-2" :message="form.errors.is_assignable" />
                            </fieldset>
                            </div>
                            <div>
                                <fieldset>
                              <legend class="text-sm font-medium leading-6 text-gray-900">User role</legend>
                              <RadioGroup v-model="form.role" class="mt-2">
                                <RadioGroupLabel class="sr-only">Role selection</RadioGroupLabel>
                                <div class="-space-y-px rounded-md bg-white">
                                <RadioGroupOption as="template" v-for="(role, roleIdx) in roles" :key="role.id" :value="role" v-slot="{ checked, active }">
                                    <div :class="[roleIdx === 0 ? 'rounded-tl-md rounded-tr-md' : '', roleIdx === roles.length - 1 ? 'rounded-bl-md rounded-br-md' : '', checked ? 'z-10 border-indigo-200 bg-indigo-50' : 'border-gray-200', 'relative flex cursor-pointer border p-4 focus:outline-none']">
                                    <span :class="[checked ? 'bg-indigo-600 border-transparent' : 'bg-white border-gray-300', active ? 'ring-2 ring-offset-2 ring-indigo-600' : '', 'mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded-full border flex items-center justify-center']" aria-hidden="true">
                                        <span class="rounded-full bg-white w-1.5 h-1.5" />
                                    </span>
                                    <span class="ml-3 flex flex-col">
                                        <RadioGroupLabel as="span" :class="[checked ? 'text-indigo-900' : 'text-gray-900', 'block text-sm font-medium capitalize']">{{ role.name }}</RadioGroupLabel>
                                        <RadioGroupDescription as="span" :class="[checked ? 'text-indigo-700' : 'text-gray-500', 'block text-sm']">{{ role.description }}</RadioGroupDescription>
                                    </span>
                                    </div>
                                </RadioGroupOption>
                                </div>
                            </RadioGroup>
                            </fieldset>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="flex flex-shrink-0 justify-end px-4 py-4">
                        <button type="button" @click="open = false; form.reset(); form.clearErrors()" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</button>
                        <button type="submit" @click.prevent="form.transform((data) => ({...data, is_assignable: data.is_assignable.value, role: data.role.name})).post(route('member.store'), {onSuccess: () => { open = false }})" class="ml-4 inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
                  </form>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
-->
  </template>
