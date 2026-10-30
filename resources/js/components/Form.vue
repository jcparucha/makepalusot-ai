<script setup lang="ts">
const emit = defineEmits(['on-submit']);
</script>

<template>
    <form @submit.prevent="$emit('on-submit')" class="border flex flex-col space-y-4 p-4">
        <slot />
    </form>
</template>
