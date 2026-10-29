<script setup lang="ts"></script>

<template>
    <header class="border-b border-slate-400 flex justify-between">
        <h1>Make<i>Palusot</i> AI</h1>
        <p>Powered by Gemini</p>
    </header>
    <div class="">
        <h1>Make<i>Palusot</i> AI</h1>
        <p>
            A <i>witty</i> AI-powered Excuse Generator. Para kahit anong excuses mo, sa work, school, or kahit sa bahay,
            makakalusot yan 🤞
        </p>
        <button class="btn primary">Sample Text</button>
    </div>
    <div class="w-full flex">
        <!-- Form and Text Area with Dropdown -->
        <form class="border w-1/2 flex flex-col space-y-4 p-4">
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

        <div class="border w-1/2 p-4">
            <h2 class="font-bold">Generated Result:</h2>
            <p>This is the result</p>
        </div>
    </div>
</template>
