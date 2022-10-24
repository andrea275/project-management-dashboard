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
import VMultiselect from "./components/UI/VMultiselect.vue";
import VButton from "./components/UI/VButton.vue";
import Loader from "./components/Loader.vue";
import Modal from "./components/Modal.vue";
import Projects from "./pages/projects/Projects.vue";
import Tasks from "./pages/project/Tasks.vue";
import Dashboard from "./pages/project/Dashboard.vue";
import Users from "./pages/project/users/Users.vue";
import Invitations from "./pages/project/invitations/Invitations.vue";
import UserInvitations from "./pages/Invitations.vue";
import Profile from "./pages/profile/Profile.vue";

app.component('VDefaultField', VDefaultField);
app.component('VLabel', VLabel);
app.component('VInput', VInput);
app.component('VTextarea', VTextarea);
app.component('VMultiselect', VMultiselect);
app.component('VButton', VButton);
app.component('Modal', Modal);
app.component('Loader', Loader);
app.component('Projects', Projects);
app.component('Tasks', Tasks);
app.component('Dashboard', Dashboard);
app.component('Users', Users);
app.component('Invitations', Invitations);
app.component('UserInvitations', UserInvitations);
app.component('Profile', Profile);

app.mount('#app');
