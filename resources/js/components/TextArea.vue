<script setup lang="ts">
type TextAreaProps = {
    class?: string;
    placeholder?: string;
};

const props = defineProps<TextAreaProps>();
const style = props.class ?? '';

const model = defineModel<string>();
</script>

<template>
    <textarea :class="[style, 'p-4']" :placeholder="placeholder" v-model="model" />
</template>
