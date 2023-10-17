<script setup>
defineProps({
    title: {
        type: String,
        requied: true
    }
})
</script>

<template>
    <div class="flex flex-wrap items-center gap-6 sm:flex-nowrap px-4 sm:px-6 lg:px-8 min-h-[36px]">
        <h1 class="text-base font-semibold leading-7 text-gray-900">{{ title }}</h1>
        <div v-if="$slots.filters" class="order-last w-full text-sm font-semibold leading-6 sm:order-none sm:w-auto sm:border-l sm:border-gray-200 sm:pl-6 sm:leading-7">
            <slot name="filters" />
        </div>
        <div v-if="$slots.actions" class="ml-auto flex items-center space-x-2">
            <slot name="actions" />
        </div>
    </div>
</template>
