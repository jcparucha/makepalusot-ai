<script setup lang="ts">
const emit = defineEmits<{
    (e: 'submit', event: SubmitEvent): void;
}>();
</script>

<template>
    <form @submit.prevent="emit('submit', $event)" class="box-container flex flex-col space-y-4 p-8">
        <slot />
    </form>
</template>
