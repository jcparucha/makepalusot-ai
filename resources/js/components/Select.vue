<script setup lang="ts">
type OptionsValue = {
    name: string;
    value: string | null;
};

type DropdownProps = {
    options?: OptionsValue[];
};

const props: DropdownProps = defineProps(['options']);
</script>

<template>
    <select>
        <option v-for="(option, index) in options" :key="index" :value="option.value">{{ option.name }}</option>
    </select>
</template>
