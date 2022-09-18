<template>
    <modal @close="$emit('close')">
        <template #title>Create Task</template>
        <template #content>
            <div class="space-y-6 bg-white">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" v-model="form.title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    </div>

                    <div class="col-span-6">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea id="description" name="description" v-model="form.description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"></textarea>
                        </div>
                    </div>

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
            priorities: []
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
            //await axios.post(`/api/project/${this.projectSlug}/task`, this.clearForm());
            await axios.post(`/api/project/${this.projectSlug}/task`, this.form);
            this.$emit('close');
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

<style scoped>

</style>
