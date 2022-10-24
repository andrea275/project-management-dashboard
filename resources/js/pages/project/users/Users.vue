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
                        <th scope="col" class="py-3 px-6" v-if="authIsAdmin">
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
                            <img
                                class="w-10 h-10 rounded-full"
                                :src="user.image"
                                :alt="user.name"
                                :title="user.name"
                                v-if="user.image"
                            >
                            <div class="inline-flex overflow-hidden relative justify-center items-center w-10 h-10 bg-gray-100 rounded-full dark:bg-gray-600" :title="user.name" v-else>
                                <span class="font-medium text-gray-600 dark:text-gray-300 text-base">
                                    {{ getFirstLetters(user.name) }}
                                </span>
                            </div>
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
                        <td class="py-4 px-6 space-x-2" v-if="authIsAdmin">
                            <button title="Edit" @click="editUser(user)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                            <button title="Remove" @click="removeUser(user)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex justify-center text-gray-700" v-else>No users found.</div>
            </div>
        </div>
    </div>

    <UpdateUser
        :project-slug="projectSlug"
        :user="user"
        v-if="user"
        @updated="handleUpdated"
        @close="user = null"
    ></UpdateUser>
</template>

<script>
import debounce from "lodash/debounce";
import helpers from "../../../mixins/helpers";
import UpdateUser from "./UpdateUser.vue";
import Swal from "sweetalert2";

export default {
    name: "Users",
    props: {
        projectSlug: {
            type: String,
            required: true
        }
    },
    mixins: [helpers],
    components: {
        UpdateUser
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
            term: '',
            user: null,
            authIsAdmin: false
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
    async mounted() {
        await this.checkIfAdmin();
        this.fetchUsers();
    },
    methods: {
        async checkIfAdmin() {
            const {data} = await axios.get(`/api/project/${this.projectSlug}/user-is-admin`);
            this.authIsAdmin = data.data;
        },
        async fetchUsers() {
            this.fetching= true;
            const term = encodeURIComponent(this.term);
            const isAdmin = encodeURIComponent(this.role ? this.role.id : '');
            const {data} = await axios.get(`/api/project/${this.projectSlug}/user?term=${term}&admin=${isAdmin}`);
            this.users = data.data;
            this.fetching = false;
        },
        async removeUser(user) {
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove them!'
            });

            if (!result.isConfirmed) return;

            try {
                await axios.delete(`/api/project/${this.projectSlug}/user/${user.token}`);
                this.users = this.users.filter(el => el.token !== user.token)
                toastr.success('User removed successfully.');
            } catch (errors) {
                toastr.error('An error occurred.');
            }
        },
        editUser(user) {
            this.user = user;
        },
        handleUpdated(user) {
            const index = this.users.findIndex(inv => inv.token === user.token);
            this.users[index] = user;
            this.user = null;
        }
    }
}
</script>
