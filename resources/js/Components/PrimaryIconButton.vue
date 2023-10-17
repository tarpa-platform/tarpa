<script setup>
defineProps({
    icon
})
</script>

<template>
    <component :is="icon" class="-ml-1.5 h-5 w-5" aria-hidden="true" />
        <slot />
</template>
