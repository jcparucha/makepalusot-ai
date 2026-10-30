<script setup lang="ts">
const emit = defineEmits<{
    (e: 'submit', event: SubmitEvent): void;
}>();
</script>

<template>
    <form @submit.prevent="emit('submit', $event)" class="border flex flex-col space-y-4 p-4">
        <slot />
    </form>
</template>
