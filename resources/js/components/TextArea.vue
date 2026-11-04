<script setup lang="ts">
import { computed } from 'vue';

type TextAreaProps = {
    class?: string;
    name?: string;
    placeholder?: string;
    errors?: errors;
};

const props = defineProps<TextAreaProps>();
const style = props.class ?? '';

const error = computed(() => {
    return props.name ? props.errors?.errors[props.name]?.[0] : undefined;
});

const model = defineModel<string>();
</script>

<template>
    <div class="flex flex-col gap-2">
        <textarea
            v-model="model"
            :name="name"
            :placeholder="placeholder"
            :class="[style, 'p-4', error ? 'border-red-500' : '']"
        />
        <p v-if="error" :id="`${name}-error`" class="text-sm text-red-500">
            {{ error }}
        </p>
    </div>
</template>
