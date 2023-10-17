<script setup>
import { ref, computed, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { router } from '@inertiajs/vue3'

const settings = usePage().props.settings

const query = ref('')

const searchResults = ref([])

const show = ref(true)

const getSearch = async() => {
    searchResults.value = await axios.get(route('api.search', { q: query.value })).then( (response) => {
        console.log(response.data)
        return response.data
    })
};

import { Link, usePage } from '@inertiajs/vue3';
import {
  Dialog,
  DialogPanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot
} from '@headlessui/vue'
import {
  Bars3Icon,
  BellIcon,
  CalendarIcon,
  Cog6ToothIcon,
  TrashIcon,
  ClipboardDocumentCheckIcon,
  HomeIcon,
  MapIcon,
  FlagIcon,
  UsersIcon,
  IdentificationIcon,
  ExclamationTriangleIcon,
  KeyIcon,
  XMarkIcon,
CheckCircleIcon,
RectangleGroupIcon
} from '@heroicons/vue/24/outline'
import { ChevronDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'

const navigation = [
    { name: 'Dashboard', href: route('dashboard'), icon: HomeIcon, current: 'dashboard', visible: true, featureflag: true },
    { name: 'Calendar', href: '#' /*route('calendar')*/, icon: CalendarIcon, current: 'calendar', visible: 'event.view-all', featureflag: true },
    { name: 'Tasks', href: route('task.index'), icon: ClipboardDocumentCheckIcon, current: 'task.*', visible: 'task.view-all', featureflag: true },
    { name: 'Participants', href: route('participant.index'), icon: UsersIcon, current: 'participant.*', visible: 'participant.view-all', featureflag: true },
]

const management = [
    { name: 'Research Team', href: route('member.index'), icon: IdentificationIcon, current: 'member.*', visible: 'member.view-all', featureflag: true },
    { name: 'Time Points', href: route('timepoint.index'), icon: MapIcon, current: 'timepoint.*', visible: 'timepoint.view-all', featureflag: settings.longitudinal },
    { name: 'Statuses', href: route('status.index'), icon: FlagIcon, current: 'status.*', visible: 'status.view-all', featureflag: true },
    { name: 'Templates', href: '#', icon: RectangleGroupIcon, current: 'templates.*', visible: ['eventtemplate.view-all', 'tasktemplate.view-all'], featureflag: true },
    { name: 'Roles & Permissions', href: route('role.index'), icon: KeyIcon, current: 'role.*', visible: 'roles.manage', featureflag: true }
]

const userNavigation = [
  { name: 'Your profile', href: route('profile.edit'), method: 'GET' },
  { name: 'Sign out', href: route('logout'), method: 'POST' },
]

let userNotificationCount = ref(null);

const updateUserNotifications = async () => {
    userNotificationCount.value = await axios.get(route('api.notifications.count')).then( (response) => {
        return response.data
    })
}

const sidebarOpen = ref(false)

const showingNavigationDropdown = ref(false);

const showNotification = ref(false)

onMounted(async ()=>{
    await updateUserNotifications();
})

router.on('navigate', (event) => {
    updateUserNotifications();
    if(usePage().props.flash.success != null){
        setTimeout(() => { showNotification.value = true }, 300)
        setTimeout(() => { showNotification.value = false }, 5300)
    }
})
</script>

<template>

<div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-900/80" />
        </TransitionChild>

        <div class="fixed inset-0 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                  <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <!-- Sidebar component, swap this element with another sidebar if you like -->
              <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                  <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
                </div>
                <nav class="flex flex-1 flex-col">
                  <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                      <ul role="list" class="-mx-2 space-y-1">
                        <li v-for="item in navigation" :key="item.name">
                            <template v-if="$authorize(item.visible) && item.featureflag">
                                <Link :href="item.href" :class="[route().current(item.current) ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                    <component :is="item.icon" :class="[route().current(item.current) ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                    {{ item.name }}
                                </Link>
                            </template>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <div class="text-xs font-semibold leading-6 text-gray-400">Study management</div>
                      <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li v-for="item in management" :key="item.name">
                            <template v-if="$authorize(item.visible) && item.featureflag">
                                <Link :href="item.href" :class="[route().current(item.current) ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                    <component :is="item.icon" :class="[route().current(item.current) ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                    <span class="truncate">{{ item.name }}</span>
                                </Link>
                            </template>
                        </li>
                      </ul>
                    </li>
                    <li class="mt-auto">
                      <Link :href="route('archive.index')" :class="[route().current('archive.*') ? 'bg-gray-50 text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600']">
                        <TrashIcon :class="[route().current('archive.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                        Recently Deleted
                      </Link>
                    </li>
                    <li class="mt-auto">
                      <Link :href="route('setting.edit')" :class="[route().current('setting.*') ? 'bg-gray-50 text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600']">
                        <Cog6ToothIcon :class="[route().current('setting.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                        Settings
                      </Link>
                    </li>
                  </ul>
                </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
        <div class="flex h-16 shrink-0 items-center">
          <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
        </div>
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                <li v-for="item in navigation" :key="item.name">
                    <template v-if="$authorize(item.visible) && item.featureflag">
                  <Link :href="item.href" :class="[route().current(item.current) ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                    <component :is="item.icon" :class="[route().current(item.current) ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                    {{ item.name }}
                  </Link>
                </template>
                </li>
              </ul>
            </li>
            <li>
              <div class="text-xs font-semibold leading-6 text-gray-400">Study management</div>
              <ul role="list" class="-mx-2 mt-2 space-y-1">
                <li v-for="item in management" :key="item.name">
                    <template v-if="$authorize(item.visible) && item.featureflag">
                  <Link :href="item.href" :class="[route().current(item.current) ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                    <component :is="item.icon" :class="[route().current(item.current) ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                    <span class="truncate">{{ item.name }}</span>
                  </Link>
                </template>
                </li>
              </ul>
            </li>
            <li class="mt-auto">
                <ul role="list" class="-mx-2 space-y-1">
                    <li v-if="$authorize(true)">
                        <Link :href="route('archive.index')" :class="[route().current('archive.*') ? 'bg-gray-50 text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'group p-2 flex gap-x-3 rounded-md text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600']">
                        <TrashIcon :class="[route().current('archive.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                        Recently Deleted
                      </Link>
                    </li>
                    <li v-if="$authorize('settings.manage')">
              <Link :href="route('setting.edit')" :class="[route().current('setting.*') ? 'bg-gray-50 text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'group p-2 flex gap-x-3 rounded-md text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600']">
                <Cog6ToothIcon :class="[route().current('setting.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                Settings
              </Link>
            </li>
                </ul>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="lg:pl-72">
      <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <Bars3Icon class="h-6 w-6" aria-hidden="true" />
        </button>
        <!-- Separator -->
        <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true" />

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
        <div class="relative flex flex-col flex-1">
            <label for="search-field" class="sr-only">Search</label>
            <MagnifyingGlassIcon class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400" aria-hidden="true" />
            <input v-model="query" @input="getSearch()" id="search-field" class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm" placeholder="Search..." type="search" name="search" />
            <!--<div class="relative" >
                <div class="absolute z-10 max-h-60 w-full overflow-auto rounded-b-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    <ul>

                        <li v-for="items" :key="category">
                            <h2 class="bg-gray-100 px-4 py-2.5 text-xs font-semibold text-gray-900">
                                {{ category }}
                            </h2>
                            <ul class="mt-2 text-sm text-gray-800">
                                <ComboboxOption v-for="item in items" :key="item.id" :value="item" as="template" v-slot="{ active }">
                                <li :class="['cursor-default select-none px-4 py-2', active && 'bg-indigo-600 text-white']">
                                    {{ item.name }}
                                </li>
                                </ComboboxOption>
                            </ul>
                        </li>


                </div>
            </div>-->
        </div>

          <div class="flex items-center gap-x-4 lg:gap-x-6">
            <Link :href="route('notifications')" type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500 relative inline-block">
              <span class="sr-only">{{ (userNotificationCount > 0) ? 'You have unread' : 'View' }} notifications</span>
              <div v-if="userNotificationCount > 0" class="absolute top-1.5 right-2 inline-block text-rose-400 bg-rose-400/10 flex-none rounded-full p-1">
                                <div class="h-1.5 w-1.5 rounded-full bg-current" />
                            </div>

                <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </Link>

            <!-- Separator -->
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" aria-hidden="true" />

            <!-- Profile dropdown -->
            <Menu as="div" class="relative">
              <MenuButton class="-m-1.5 flex items-center p-1.5">
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full bg-gray-50" :src="'https://ui-avatars.com/api?background=e0e7ff&color=4338ca&name=' + $page.props.auth.user.name" alt="" />
                <span class="hidden lg:flex lg:items-center">
                  <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ $page.props.auth.user.name }}</span>
                  <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
              </MenuButton>
              <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                <MenuItems class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                  <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                    <Link :href="item.href" :method="item.method" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">{{ item.name }}</Link>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
      </div>
      <!-- Search Results -->
      <TransitionRoot
      :show="query != ''"
    enter="translate transition duration-200"
    enter-from="-translate-y-full"
    enter-to="translate-y-0"
    leave="translate transition duration-200"
    leave-from="translate-y-0"
    leave-to="-translate-y-full"
    class="z-30 absolute max-h-60 w-[calc(100%-theme(space.72))] overflow-auto shadow-sm border-b border-gray-200 bg-white"
  >
  <div v-if="query !== '' && searchResults.length === 0" class=" text-left text-sm sm:px-6 lg:px-16 py-6">
                    <p class="font-semibold text-gray-900">No results found</p>
                    <p class="mt-2 text-gray-500">We couldn’t find anything with that term. Please try again.</p>
              </div>
      <div v-else class="" v-for="(items, category) in searchResults">
        <div class="py-2">
            <span class="text-gray-900 px-16 text-sm leading-6 font-semibold capitalize">{{ category }}</span>
        </div>
            <ul class="">
                <li v-for="item in items" :key="item.searchable.id" :value="item" class="relative block w-ful">
                    <Link @click="query = ''" :href="item.url" class="px-16 text-gray-700 hover:text-indigo-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6">
                        {{ item.title }}
                    </Link>
                </li>
            </ul>
        </div>


        <!-- End Search Results -->
    </TransitionRoot>

      <main class="py-10">
        <slot />
      </main>
    </div>

  </div>
  <!-- Global notification live region, render this permanently at the end of the document -->
  <div aria-live="assertive" class="z-50 pointer-events-none fixed inset-y-16 inset-x-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
      <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
      <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition transform ease-in duration-200" leave-from-class="opacity-100" leave-to-class="translate-x-full">
        <div v-if="$page.props.flash.error" class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <ExclamationTriangleIcon class="h-6 w-6 text-red-400" aria-hidden="true" />
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">{{ $page.props.flash.error.title }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ $page.props.flash.error.message }}</p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button type="button" @click="$page.props.flash.error = null" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                </button>
              </div>
            </div>
          </div>
        </div>
        </transition>
        <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition transform ease-in duration-200" leave-from-class="opacity-100" leave-to-class="translate-x-full">
        <div v-if="showNotification" class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <CheckCircleIcon class="h-6 w-6 text-green-400" aria-hidden="true" />
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">{{ $page.props.flash.success.title }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ $page.props.flash.success.message }}</p>
              </div>
              <div class="ml-4 flex flex-shrink-0">
                <button type="button" @click="$page.props.flash.success = null" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>
