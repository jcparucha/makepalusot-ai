<script setup lang="ts">
import { computed } from 'vue';

type OptionsValue = {
    name: string;
    value: string | null;
};

const props = defineProps<{
    name?: string;
    options?: OptionsValue[];
    errors?: errors;
}>();

const error = computed(() => {
    return props.name ? props.errors?.errors[props.name]?.[0] : undefined;
});

const model = defineModel<string | null>();
</script>

<template>
    <div class="w-full flex flex-col gap-2">
        <select
            v-model="model"
            :name="name"
            :class="['rounded-md dark:bg-slate-900 w-full p-2', error ? 'border-red-500' : '']"
        >
            <option v-for="(option, index) in props.options" :key="index" :value="option.value">
                {{ option.name }}
            </option>
        </select>
        <p v-if="error" :id="`${name}-error`" class="text-sm text-red-500">
            {{ error }}
        </p>
    </div>
</template>
