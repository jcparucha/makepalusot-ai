<script setup lang="ts">
import AppName from './components/AppName.vue';
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
            <button class="btn secondary rounded-full px-4 mt-2">Sample Text</button>
        </section>
        <section class="w-full flex flex-col space-y-4">
            <!-- Form and Text Area with Dropdown -->
            <form class="border flex flex-col space-y-4 p-4">
                <textarea class="border w-full" placeholder="I don't want to go to work. I'm too lazy for that." />
                <div class="flex space-x-2">
                    <select>
                        <option value="">Select Tone</option>
                        <option value="formal">Formal</option>
                        <option value="friendly">Friendly</option>
                        <option value="casual">Casual</option>
                    </select>
                    <select>
                        <option value="">Select Language</option>
                        <option value="english">English</option>
                        <option value="taglish">Taglish</option>
                        <option value="tagalog">Tagalog</option>
                    </select>
                </div>
                <button class="btn primary" type="submit">Generate</button>
            </form>

            <div class="border p-4">
                <h2 class="font-bold">Generated Result:</h2>
                <p>This is the result</p>
            </div>
        </section>
    </main>
</template>
