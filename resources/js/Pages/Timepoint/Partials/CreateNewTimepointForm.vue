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
    description: '',
    offset: 0
})

const descriptionInput = ref(null)
const open = ref(false)

const openPanel = () => { open.value = true }

defineExpose({
    openPanel
})
</script>

<template>
    <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-50" :initialFocus="descriptionInput" @close="open = false">
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
                        <DialogTitle class="text-base font-semibold leading-6 text-white">New Timepoint</DialogTitle>
                        <div class="ml-3 flex h-7 items-center">
                          <button type="button" class="relative rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="open = false">
                            <span class="absolute -inset-2.5" />
                            <span class="sr-only">Close panel</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                          </button>
                        </div>
                      </div>
                      <div class="mt-1">
                        <p class="text-sm text-indigo-300">Timepoints define participant observations through longitudinal studies.</p>
                      </div>
                    </div>
                    <div class="flex flex-1 flex-col justify-between">
                      <div class="divide-y divide-gray-200 px-4 sm:px-6">
                        <div class="space-y-6 pb-5 pt-6">
                            <div>
                                <InputLabel for="description" value="Description" />
                                <TextInput
                                    type="text"
                                    v-model="form.description"
                                    id="description"
                                    class="mt-1 block w-full"
                                    ref="descriptionInput"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>
                            <div>
                                <InputLabel for="offset" value="Offset" />
                                <TextInput
                                    type="number"
                                    v-model="form.offset"
                                    id="offset"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.offset" />
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
                    <button type="submit" @click.prevent="form.post(route('timepoint.store'), {onSuccess: () => { open = false }})" class="ml-4 inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                  </div>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
  </template>
