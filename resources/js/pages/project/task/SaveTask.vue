<template>
    <modal @close="$emit('close')">
        <template #title>Create Task</template>
        <template #content>
            <div class="space-y-6 bg-white">
                <div class="grid grid-cols-6 gap-6">
                    <VDefaultField
                        classes="col-span-6 space-y-1"
                        :error="errors.get('title')"
                    >
                        <VLabel labelFor="title">Title</VLabel>
                        <VInput
                            id="title"
                            :error="errors.get('title')"
                            v-model="form.title"
                            @input="errors.clear('title')"
                        ></VInput>
                    </VDefaultField>

                    <VDefaultField
                        classes="col-span-6 space-y-1"
                        :error="errors.get('description')"
                    >
                        <VLabel labelFor="description">Description</VLabel>
                        <VTextarea
                            id="description"
                            :error="errors.get('description')"
                            v-model="form.description"
                            @input="errors.clear('description')"
                        ></VTextarea>
                    </VDefaultField>

                    <VDefaultField
                        classes="col-span-6 space-y-1"
                        :error="errors.get('status')"
                    >
                        <VLabel labelFor="status">Status</VLabel>
                        <VMultiselect
                            id="status"
                            label="name"
                            track-by="id"
                            classes="mt-1"
                            :options="statuses"
                            v-model="form.status"
                        ></VMultiselect>
                    </VDefaultField>

                    <VDefaultField
                        classes="col-span-6 space-y-1"
                        :error="errors.get('priority')"
                    >
                        <VLabel labelFor="priority">Priority</VLabel>
                        <VMultiselect
                            id="priority"
                            label="name"
                            track-by="id"
                            classes="mt-1"
                            :options="priorities"
                            v-model="form.priority"
                        ></VMultiselect>
                    </VDefaultField>

                    <VDefaultField
                        classes="col-span-6 space-y-1"
                        :error="errors.get('users')"
                    >
                        <VLabel labelFor="users">Assign Users</VLabel>
                        <VMultiselect
                            id="users"
                            label="name"
                            track-by="token"
                            classes="mt-1"
                            :options="users"
                            :multiple="true"
                            :closeOnSelect="false"
                            v-model="form.users"
                        ></VMultiselect>
                    </VDefaultField>
                </div>
            </div>
        </template>
        <template #actions>
            <VButton color="white" @click="$emit('close')">Cancel</VButton>
            <VButton color="primary" @click="saveTask">Create</VButton>
        </template>
    </modal>
</template>

<script>
import Errors from "../../../helpers/Errors";

export default {
    name: "SaveTask",
    emits: ['close', 'saved'],
    props: {
        projectSlug: {
            type: String,
            required: true
        },
        status: Number
    },
    data() {
        return {
            form: {
                title: null,
                description: null,
                status: null,
                priority: null,
                users: []
            },
            users: [],
            statuses: [],
            priorities: [],
            errors: new Errors()
        }
    },
    mounted() {
        this.fetchUsers();
        this.fetchStatuses();
        this.fetchPriorities();
    },
    methods: {
        async fetchUsers() {
            const {data} = await axios.get(`/api/project/${this.projectSlug}/user`);
            this.users = data.data;
        },
        async fetchStatuses() {
            const {data} = await axios.get('/api/status');
            this.statuses = data.data;

            if (this.status) this.form.status = this.statuses.find(status => status.id === this.status);
        },
        async fetchPriorities() {
            const {data} = await axios.get('/api/priority');
            this.priorities = data.data;
        },
        async saveTask() {
            try {
                const {data} = await axios.post(`/api/project/${this.projectSlug}/task`, this.clearForm());
                this.$emit('saved', data.data);

                toastr.success('Task saved successfully!');
            } catch (errors) {
                if (errors.response.status === 422) {
                    this.errors.record(errors.response.data.errors);
                    return;
                }

                toastr.error('An error occurred!');
            }
        },
        clearForm() {
            const form = Object.assign({}, this.form);

            form.status = this.form.status?.id || '';
            form.priority = this.form.priority?.id || '';
            form.users = this.form.users.map(user => user.token);

            return form;
        }
    }
}
</script>
