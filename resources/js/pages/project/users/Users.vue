<template>
    <div class="px-12 py-12 w-full">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl block mb-16">
            Users
        </h1>

        <div class="overflow-x-auto relative">
            <div class="flex justify-between items-center pb-4 bg-white">
                <div class="w-56">
                    <VMultiselect
                        id="role"
                        label="name"
                        track-by="name"
                        classes="mt-1"
                        :options="roles"
                        :preselect-first="true"
                        :allow-empty="false"
                        v-model="role"
                    ></VMultiselect>
                </div>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" id="table-search-users" class="block p-2 pl-10 w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for users" v-model="term">
                </div>
                <VButton color="primary" @click="addUser = true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-white">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    <span class="ml-2">Invite User</span>
                </VButton>
            </div>
            <div class="mt-8">
                <div class="flex justify-center" v-if="fetching">
                    <Loader size="small"></Loader>
                </div>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" v-else-if="users.length">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Admin
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        class="bg-white hover:bg-gray-50"
                        v-for="(user, index) in users"
                        :key="index"
                        :class="{'border-b': index < users.length - 1}"
                    >
                        <th scope="row" class="flex items-center py-4 px-6 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Jese image">
                            <div class="pl-3">
                                <div class="text-base font-semibold">{{ user.name }}</div>
                                <div class="font-normal text-gray-500">{{ user.email }}</div>
                            </div>
                        </th>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-500" v-if="user.isAdmin">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-500" v-else>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </td>
                        <td class="py-4 px-6 space-x-2">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex justify-center text-gray-700" v-else>No users found.</div>
            </div>
        </div>
    </div>

    <InviteUser :project-slug="projectSlug" v-if="addUser" @close="addUser = false"></InviteUser>
</template>

<script>
import InviteUser from "./InviteUser.vue";
import debounce from "lodash/debounce";

export default {
    name: "Users",
    props: {
        projectSlug: {
            type: String,
            required: true
        }
    },
    components: {
        InviteUser
    },
    data() {
        return {
            users: [],
            addUser: false,
            roles: [
                {id: 'all', name: 'All'},
                {id: 'admin', name: 'Admin'},
                {id: 'editor', name: 'Editor'}
            ],
            fetching: true,
            role: {id: 'all', name: 'All'},
            term: ''
        }
    },
    watch: {
        'term': {
            handler: debounce(function () {
                if (this.fetching) return;
                this.fetchUsers();
            }, 500)
        },
        'role': 'fetchUsers'
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        async fetchUsers() {
            this.fetching= true;
            const term = encodeURIComponent(this.term);
            const isAdmin = encodeURIComponent(this.role ? this.role.id : '');
            const {data} = await axios.get(`/api/project/${this.projectSlug}/user?term=${term}&admin=${isAdmin}`);
            this.users = data.data;
            this.fetching = false;
        }
    }
}
</script>

<style scoped>

</style>
