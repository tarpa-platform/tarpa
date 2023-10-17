<script setup>
import { Head } from '@inertiajs/vue3';
import PageHeading from '@/Components/PageHeading.vue';
defineProps({
    task: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <Head :title="task.title" />
    <PageHeading :title="task.title">
        <template #filters></template>
        <template #actions></template>
    </PageHeading>
</template>
