<script setup lang="ts">
import { reactive, ref } from 'vue';
import Button from '../Button.vue';
import Form from '../Form.vue';
import Select from '../Select.vue';
import TextArea from '../TextArea.vue';

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

const generatedResult = ref('');

const form = reactive({
    excuse: '',
    tone: '',
    language: ''
});

function handleOnSubmit() {
    // TODO add fetch request
    console.log(form);

    const response = {
        data: {
            model: 'test-model-alpha',
            result: 'This is the generated result.',
            errors: []
        }
    };

    generatedResult.value = response.data.result;
}

function handleOnClick() {
    form.excuse = exampleExcuse;
    form.tone = 'formal';
    form.language = 'english';
}

function handleOnClickCopy() {
    console.log('Copied');
}

console.log(form);
</script>

<template>
    <section class="w-full flex flex-col space-y-4">
        <Button class="rounded-full px-4 mt-2" variant="secondary" @click="handleOnClick"> Try Sample Excuse </Button>

        <Form @submit="handleOnSubmit">
            <!-- TODO beautify input fields -->
            <TextArea v-model="form.excuse" :placeholder="exampleExcuse" />
            <div class="flex justify-between space-x-4">
                <Select v-model="form.tone" :options="toneOptions" />
                <Select v-model="form.language" :options="langOptions" />
            </div>
            <Button type="submit">Generate</Button>
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
