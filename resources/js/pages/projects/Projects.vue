<template>
    <div class="p-12 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-16">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl block">
                Projects
            </h1>
            <VButton color="primary" @click="createProject = true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-white">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <span class="ml-2">New project</span>
            </VButton>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <a :href="`/project/${project.slug}/dashboard`" class="p-6 bg-white border border-gray-200 overflow-hidden shadow sm:rounded-lg" v-for="project in projects" :key="project.slug">
                <h2 class="text-gray-900 text-xl font-semibold mb-4">{{ project.title }}</h2>

                <div class="flex -space-x-1 overflow-hidden mb-2">
                    <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <span class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-blue-500 text-white text-xs flex items-center justify-center">+2</span>
                </div>

                <div class="text-gray-700 text-sm">
                    Created by <strong>{{ project.user.name }}</strong> on <strong>{{ project.createdAt }}</strong>
                </div>
            </a>
        </div>
    </div>

    <SaveProject v-if="createProject" @saved="handleCreatedProject" @close="createProject = false"></SaveProject>
</template>

<script>
import SaveProject from "./SaveProject.vue";

export default {
    name: "Projects",
    components: {
        SaveProject
    },
    data() {
        return {
            projects: [],
            createProject: false
        }
    },
    mounted() {
        this.fetchProjects();
    },
    methods: {
        async fetchProjects() {
            const {data} = await axios.get('/api/project');
            this.projects = data.data;
        },
        handleCreatedProject(project) {
            this.projects.unshift(project);
            this.createProject = false;
        }
    }
}
</script>
