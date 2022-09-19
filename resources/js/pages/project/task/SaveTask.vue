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

                    <div class="col-span-6 sm:col-span-3">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" v-model="form.status" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option v-for="status in statuses" :value="status.id">{{ status.name }}</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                        <select id="priority" name="priority" v-model="form.priority" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option v-for="priority in priorities" :value="priority.id">{{ priority.name }}</option>
                        </select>
                    </div>
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
    emits: ['close'],
    props: {
        projectSlug: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            form: {
                title: null,
                description: null,
                status: null,
                priority: null
            },
            statuses: [],
            priorities: [],
            errors: new Errors()
        }
    },
    mounted() {
        this.fetchStatuses();
        this.fetchPriorities();
    },
    methods: {
        async fetchStatuses() {
            const {data} = await axios.get('/api/status');
            this.statuses = data.data;
        },
        async fetchPriorities() {
            const {data} = await axios.get('/api/priority');
            this.priorities = data.data;
        },
        async saveTask() {
            try {
                //await axios.post(`/api/project/${this.projectSlug}/task`, this.clearForm());
                await axios.post(`/api/project/${this.projectSlug}/task`, this.form);
                this.$emit('close');

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

            form.status = this.form.status.id;
            form.priority = this.form.priority.id;

            return form;
        }
    }
}
</script>
