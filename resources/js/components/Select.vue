<script setup lang="ts">
type OptionsValue = {
    name: string;
    value: string | null;
};

const props = defineProps<{
    options?: OptionsValue[];
}>();

const model = defineModel<string | null>();
</script>

<template>
    <select v-model="model" class="rounded-md dark:bg-slate-900 w-full p-2">
        <option v-for="(option, index) in props.options" :key="index" :value="option.value">
            {{ option.name }}
        </option>
    </select>
</template>
