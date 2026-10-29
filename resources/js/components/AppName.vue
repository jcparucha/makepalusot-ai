<script setup lang="ts">
const props = defineProps(['class']);
</script>

<template>
    <h1 :class="['app-name', props.class ? props.class : '']"><b>Make</b><i class="underline">Palusot</i> <b>AI</b></h1>
</template>
