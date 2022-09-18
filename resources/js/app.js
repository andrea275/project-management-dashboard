import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';

const app = createApp({});

import VButton from "./components/UI/VButton.vue";
import Modal from "./components/Modal.vue";
import Project from "./pages/project/Project.vue";
import Users from "./pages/project/users/Users.vue";

app.component('VButton', VButton);
app.component('Modal', Modal);
app.component('Project', Project);
app.component('Users', Users);

app.mount('#app');
