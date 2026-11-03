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
    form.excuse = "I don't want to do anything and just want sleep all day.";
    form.tone = 'formal';
    form.language = 'english';
}

console.log(form);
</script>

<template>
    <section class="w-full flex flex-col space-y-4">
        <Button class="rounded-full px-4 mt-2" variant="secondary" @click="handleOnClick">Try Sample Excuse</Button>
        <Form @submit="handleOnSubmit">
            <!-- TODO beautify input fields -->
            <TextArea
                v-model="form.excuse"
                class="border w-full"
                placeholder="I don't want to go to work. I'm too lazy for that."
            />
            <Select v-model="form.tone" :options="toneOptions" />
            <Select v-model="form.language" :options="langOptions" />
            <Button type="submit">Generate</Button>
        </Form>

        <div class="border p-4">
            <h2 class="font-bold">Generated Result:</h2>
            <p>
                <span v-if="generatedResult">{{ generatedResult }}</span>
                <span v-else class="text-slate-500">No generated result yet</span>
            </p>
        </div>
    </section>
</template>
