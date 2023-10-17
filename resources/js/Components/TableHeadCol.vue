<script setup>
const props = defineProps({
    visible: {
        type: String,
        default: 'hidden sm:table-cell'
    }
})
</script>

<template>
    <th scope="col" :class="[props.visible, 'px-3 py-3.5 text-left text-sm font-semibold text-gray-900']">
        <slot />
    </th>
</template>
