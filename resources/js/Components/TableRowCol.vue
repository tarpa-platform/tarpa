<script setup>
const props = defineProps({
    visible: {
        type: String,
        default: 'hidden sm:table-cell'
    },
    value: {
        type: String
    }
})
</script>
<template>
    <td :class="[props.visible, 'px-3 py-4 first-of-type:px-0 last-of-type:text-right text-sm text-gray-500']">
        <span v-if="!$slots.cell">{{ props.value }}</span>
        <slot name="cell" />
    </td>
</template>
