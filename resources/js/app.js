import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';

const app = createApp({});

import Project from "./pages/project/Project.vue";

app.component('Project', Project);

app.mount('#app');
