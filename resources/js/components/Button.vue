<script setup lang="ts">
type ButtonProps = {
    variant?: 'primary' | 'secondary';
    class?: string;
    type?: 'button' | 'submit';
};

const props: ButtonProps = defineProps(['variant', 'class', 'type']);

const type = props?.type ?? 'button';
const style = props.variant === 'secondary' ? 'secondary' : 'primary';
</script>

<template>
    <button class="btn" :class="[style, props.class ?? '']" :type="type">
        <slot />
    </button>
</template>
