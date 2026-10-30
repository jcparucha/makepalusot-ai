<script setup lang="ts">
import { ref } from 'vue';
import Button from '../Button.vue';
import Form from '../Form.vue';
import Select from '../Select.vue';
import TextArea from '../TextArea.vue';

const toneOptions = ref([
    { name: 'Select Tone', value: null },
    { name: 'Formal', value: 'formal' },
    { name: 'Friendly', value: 'friendly' },
    { name: 'Casual', value: 'casual' }
]);
const langOptions = ref([
    { name: 'Select Language', value: null },
    { name: 'English', value: 'english' },
    { name: 'Taglish', value: 'taglish' },
    { name: 'Tagalog', value: 'tagalog' }
]);
</script>

<template>
    <section class="w-full flex flex-col space-y-4">
        <Form>
            <TextArea class="border w-full" placeholder="I don't want to go to work. I'm too lazy for that." />
            <Select :options="toneOptions" />
            <Select :options="langOptions" />
            <Button type="submit">Generate</Button>
        </Form>

        <div class="border p-4">
            <h2 class="font-bold">Generated Result:</h2>
            <p>This is the result</p>
        </div>
    </section>
</template>
