<script setup lang="ts">
import AppName from './components/AppName.vue';
import Button from './components/Button.vue';
import FormResult from './components/ui/FormResult.vue';
import Header from './components/ui/Header.vue';
</script>

<template>
    <Header />
    <main class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-8">
        <section class="space-y-2 items-center">
            <AppName class="text-5xl" />
            <p class="text-2xl">A <i class="underline">witty</i> AI-powered Excuse Generator.</p>
            <p class="text-slate-400 text-sm">
                <i>Para kahit anong excuses mo, sa work, school, or kahit sa bahay, makakalusot yan 🤞 </i>
            </p>
            <Button class="rounded-full px-4 mt-2" variant="secondary"> Sample Text</Button>
        </section>
        <FormResult />
    </main>
</template>
