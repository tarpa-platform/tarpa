<template>
    <table class="w-full text-left">
        <thead v-if="$slots.thead" class="bg-white">
            <tr>
                <slot name="thead" />
            </tr>
        </thead>
        <tbody>
            <slot />
        </tbody>
    </table>
</template>
