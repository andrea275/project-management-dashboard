<template>
    <div v-if="loading"></div>
    <div class="p-12" v-else>
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl block mb-16">
            {{ project.title }}
        </h1>

        <div>
            <div class="grid grid-cols-4 gap-4">
                <div class="p-2 bg-gray-100 rounded shadow space-y-2 h-fit" v-for="status in statuses" :key="status.id">
                    <div class="flex justify-between items-center text-white pl-4 pr-3 py-1 rounded space-x-4" :class="`bg-${status.color}-500`">
                        <div class="flex items-center space-x-2">
                            <div>
                                {{ status.name }}
                            </div>
                            <div class="px-2 text-sm rounded" :class="`bg-${status.color}-400`">
                                {{ status.tasks.length }}
                            </div>
                        </div>
                        <div class="p-1 cursor-pointer rounded" :class="`hover:bg-${status.color}-400`" @click="newTask(status.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded px-4 py-2" v-for="task in status.tasks" :key="task.uuid">
                        <h3 class="text-md font-bold mb-2 cursor-pointer" @click="activeTask = task">{{ task.title }}</h3>
                        <div class="text-gray-500 text-sm mb-2">{{ task.description }}</div>
                        <div
                            class="inline-flex rounded p-1 text-xs font-bold"
                            :class="`bg-${task.priority.color}-100 text-${task.priority.color}-500`"
                            v-if="task.priority"
                        >
                            {{ task.priority.name }}
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <div class="flex -space-x-1 overflow-hidden">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </div>

                            <div class="flex items-center text-sm text-gray-500 space-x-2">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                    <span class="ml-1">10</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                    </svg>
                                    <span class="ml-1">2</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center border-2 border-dashed border-gray-300 hover:border-gray-400 rounded px-4 py-1 text-sm text-gray-700 hover:text-gray-900 cursor-pointer" @click="newTask(status.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M10.75 6.75a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" />
                        </svg>
                        <span class="ml-1">Add Card</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <SaveTask :project-slug="projectSlug" :status="newTaskStatus" v-if="saveTask" @close="saveTask = false"></SaveTask>
    <ShowTask :task="activeTask" v-if="activeTask" @close="activeTask = null"></ShowTask>
</template>

<script>
import SaveTask from "./task/SaveTask.vue";
import ShowTask from "./task/ShowTask.vue";

export default {
    name: "Project",
    props: {
        projectSlug: {
            type: String,
            required: true
        }
    },
    components: {
        SaveTask,
        ShowTask
    },
    data() {
        return {
            project: null,
            statuses: null,
            saveTask: false,
            tasks: [],
            loading: true,
            activeTask: null,
            newTaskStatus: null
        }
    },
    async mounted() {
        await this.fetchProject();
        await this.fetchStatuses();
        await this.fetchTasks();
        this.loading = false;
    },
    methods: {
        async fetchProject() {
            const {data} = await axios.get(`/api/project/${this.projectSlug}`);
            this.project = data.data;
        },
        async fetchStatuses() {
            const {data} = await axios.get('/api/status');
            this.statuses = data.data;
        },
        async fetchTasks() {
            const {data} = await axios.get(`/api/project/${this.projectSlug}/task`);

            this.statuses.forEach((status) => {
                status.tasks = data.data.filter(task => task.status.id === status.id);
            });
        },
        newTask(status) {
            this.saveTask = true;
            this.newTaskStatus = status;
        }
    }
}
</script>
