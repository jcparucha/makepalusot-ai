<script setup lang="ts">
type TextAreaProps = {
    class?: string;
    placeholder?: string;
};

const props = defineProps<TextAreaProps>();

const model = defineModel<string>();
</script>

<template>
    <textarea :class="class" :placeholder="placeholder" v-model="model" />
</template>
