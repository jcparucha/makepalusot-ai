<script setup lang="ts">
type TextAreaProps = {
    class?: string;
    placeholder?: string;
};

const props: TextAreaProps = defineProps(['class', 'placeholder']);
</script>

<template>
    <textarea :class="class" :placeholder="placeholder" />
</template>
