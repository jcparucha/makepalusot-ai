<script setup lang="ts">
import { useFetch } from '@/composables/useFetch.js';
import { computed, onUnmounted, reactive, ref } from 'vue';
import Button from '../Button.vue';
import Form from '../Form.vue';
import Select from '../Select.vue';
import TextArea from '../TextArea.vue';

type formData = {
    excuse: string;
    tone: string;
    language: string;
};

const toneOptions = [
    { name: 'Select Tone', value: '' },
    { name: 'Formal', value: 'formal' },
    { name: 'Friendly', value: 'friendly' },
    { name: 'Casual', value: 'casual' }
];

const langOptions = [
    { name: 'Select Language', value: '' },
    { name: 'English', value: 'english' },
    { name: 'Taglish', value: 'taglish' },
    { name: 'Tagalog', value: 'tagalog' }
];

const exampleExcuse = "I don't want to go to work. I'm too lazy for that.";

const form = reactive({
    excuse: '',
    tone: '',
    language: ''
});

const cooldown = ref(0);
const generatedResult = ref('');
let intervalId: number | undefined;

function startCooldown(seconds: number = 5) {
    cooldown.value = seconds;

    intervalId = window.setInterval(() => {
        cooldown.value -= 1;
        if (cooldown.value <= 0) {
            cooldown.value = 0;
            clearInterval(intervalId);
        }
    }, 1000);
}

const { data, errors, isLoading, execute } = useFetch<formData>('/api/v1/generate', form, startCooldown);

const errorMessage = computed(() => {
    const systemErrors = errors.value?.errors.system;
    if (systemErrors?.length) {
        return systemErrors.join(' ');
    }
});

async function handleOnSubmit() {
    if (isLoading.value || cooldown.value > 0) return;

    await execute();

    generatedResult.value = data.value?.data.result ?? '';
}

function handleOnClick() {
    form.excuse = exampleExcuse;
    form.tone = 'formal';
    form.language = 'english';
}

function handleOnClickCopy() {
    console.log('Copied');
}

onUnmounted(() => clearInterval(intervalId));
</script>

<template>
    <section class="w-full flex flex-col space-y-4">
        <Button class="rounded-full px-4 mt-2" variant="secondary" @click="handleOnClick"> Try Sample Excuse </Button>

        <Form @submit="handleOnSubmit">
            <p class="p-4 box-error" v-if="errorMessage">
                {{ errorMessage }}
            </p>

            <TextArea v-model="form.excuse" :placeholder="exampleExcuse" :errors="errors" />

            <div class="flex justify-between space-x-4">
                <Select v-model="form.tone" :options="toneOptions" :errors="errors" />
                <Select v-model="form.language" :options="langOptions" :errors="errors" />
            </div>

            <Button type="submit" :disabled="isLoading || cooldown > 0">
                {{ isLoading ? 'Generating...' : 'Generate' }}
                <span v-if="cooldown != 0">&nbsp;({{ cooldown }})</span>
            </Button>
        </Form>

        <div class="box-container p-8 space-y-4">
            <h2 class="font-bold mb-2">Generated Result:</h2>
            <p>
                <span v-if="generatedResult">{{ generatedResult }}</span>
                <span v-else class="text-slate-500">No generated result yet</span>
            </p>
            <Button v-if="generatedResult" class="px-4 w-full" variant="secondary" @click="handleOnClickCopy">
                Copy Excuse
            </Button>
        </div>
    </section>
</template>
