import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import Toast, { useToast } from "vue-toastification";

import "vue-toastification/dist/index.css";

const app = createApp({});

app.use(Toast, {
    transition: "Vue-Toastification__bounce",
    maxToasts: 20,
    newestOnTop: true
});

window.toastr = useToast();

import VDefaultField from "./components/UI/VDefaultField.vue";
import VLabel from "./components/UI/VLabel.vue";
import VInput from "./components/UI/VInput.vue";
import VTextarea from "./components/UI/VTextarea.vue";
import VButton from "./components/UI/VButton.vue";
import Modal from "./components/Modal.vue";
import Project from "./pages/project/Project.vue";
import Users from "./pages/project/users/Users.vue";

app.component('VDefaultField', VDefaultField);
app.component('VLabel', VLabel);
app.component('VInput', VInput);
app.component('VTextarea', VTextarea);
app.component('VButton', VButton);
app.component('Modal', Modal);
app.component('Project', Project);
app.component('Users', Users);

app.mount('#app');
