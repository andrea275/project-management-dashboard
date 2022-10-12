<template>
    <div>
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl block mb-16">
            Invitations
        </h1>

        <div class="overflow-x-auto relative mt-8">
            <div class="flex justify-center" v-if="fetching">
                <Loader size="small"></Loader>
            </div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" v-else-if="invitations.length">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">
                        Project
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Invited By
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr
                    class="bg-white hover:bg-gray-50"
                    v-for="(invitation, index) in invitations"
                    :key="index"
                    :class="{'border-b': index < invitations.length - 1}"
                >
                    <td class="py-4 px-6">
                        <div class="text-base text-gray-900 font-semibold">{{ invitation.project.title }}</div>
                    </td>
                    <td class="flex items-center py-4 px-6 text-gray-900 whitespace-nowrap dark:text-white">
                        <img
                            class="w-10 h-10 rounded-full"
                            :src="invitation.user.image"
                            :alt="invitation.user.name"
                            :title="invitation.user.name"
                            v-if="invitation.user.image"
                        >
                        <div class="overflow-hidden relative w-10 h-10 bg-gray-100 rounded-full" v-else>
                            <svg class="absolute -left-1 w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="pl-3">
                            <div class="text-base font-semibold">{{ invitation.user.name }}</div>
                            <div class="font-normal text-gray-500">{{ invitation.user.email}}</div>
                        </div>
                    </td>
                    <td class="py-4 px-6 space-x-2">
                        <div class="flex items-center space-x-4">
                            <button title="Accept Invitation" @click="acceptInvitation(invitation)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-green-500">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button title="Refuse Invitation" @click="refuseInvitation(invitation)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-red-500">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="flex justify-center text-gray-700" v-else>No invitations found.</div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    name: "Invitations",
    data() {
        return {
            invitations: [],
            fetching: true
        }
    },
    mounted() {
        this.fetchInvitations();
    },
    methods: {
        async fetchInvitations() {
            const {data} = await axios.get(`/api/invitation`);
            this.invitations = data.data;
            this.fetching = false;
        },
        async acceptInvitation(invitation) {
            try {
                await axios.get(`/api/invitation/${invitation.token}/accept`);
                window.location.href = `/project/${invitation.project.slug}/dashboard`;
            } catch (errors) {
                toastr.error('An error occurred.');
            }
        },
        async refuseInvitation(invitation) {
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, refuse it!'
            });

            if (!result.isConfirmed) return;

            try {
                await axios.delete(`/api/invitation/${invitation.token}`);
                this.invitations = this.invitations.filter(el => el.token !== invitation.token)
                toastr.success('Invitation refused successfully.');
            } catch (errors) {
                toastr.error('An error occurred.');
            }
        }
    }
}
</script>
