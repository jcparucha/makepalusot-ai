import App from '@/App.vue';
import { createApp } from 'vue';

const app = createApp(App);

// captures errors from all components
app.config.errorHandler = (err: any) => {
    console.error('Something went wrong: ', err);
};

// NOTE add once I have a router
// app.use(router)

app.mount('#app');
