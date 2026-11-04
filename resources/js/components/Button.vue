<script setup lang="ts">
type ButtonProps = {
    variant?: 'primary' | 'secondary';
    class?: string;
    type?: 'button' | 'submit';
    disabled?: boolean;
};

const props = defineProps<ButtonProps>();
const emit = defineEmits<{
    (e: 'click', event: MouseEvent): void;
}>();

const type = props?.type ?? 'button';
const style = props.variant === 'secondary' ? 'secondary' : 'primary';
</script>

<template>
    <button
        class="btn"
        :class="[style, props.class ?? '', disabled ? 'disabled' : '']"
        :type="type"
        @click="emit('click', $event)"
        :disabled="disabled"
    >
        <slot />
    </button>
</template>
