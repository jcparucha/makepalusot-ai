<script setup lang="ts">
import { useFetch } from '@/composables/useFetch.js';
import { computed, onUnmounted, reactive, ref } from 'vue';
import { z } from 'zod';
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

const formSchema = z.object({
    excuse: z.string().trim().min(1, 'The excuse field is required.'),
    tone: z.string().trim().min(1, 'The language field is required.'),
    language: z.string().trim().min(1, 'The tone field is required.')
});

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

const validationErrors = ref<errors | null>(null);
const formErrors = computed(() => validationErrors.value ?? errors.value ?? undefined);

const errorMessage = computed(() => {
    const systemErrors = errors.value?.errors.system;
    if (systemErrors?.length) {
        return systemErrors.join(' ');
    }
});

async function handleOnSubmit() {
    if (isLoading.value || cooldown.value > 0) return;

    const validation = formSchema.safeParse(form);

    if (!validation.success) {
        const fieldErrors: Record<string, string[]> = {};

        for (const issue of validation.error.issues) {
            console.log(issue);
            const field = issue.path[0];

            if (typeof field === 'string') {
                (fieldErrors[field] ??= []).push(issue.message);
            }
        }

        validationErrors.value = { errors: fieldErrors };
        return;
    }

    validationErrors.value = null;

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

            <TextArea name="excuse" v-model="form.excuse" :placeholder="exampleExcuse" :errors="formErrors" />

            <div class="flex justify-between space-x-4">
                <Select name="tone" v-model="form.tone" :options="toneOptions" :errors="formErrors" />
                <Select name="language" v-model="form.language" :options="langOptions" :errors="formErrors" />
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
