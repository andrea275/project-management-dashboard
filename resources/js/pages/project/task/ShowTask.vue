<template>
    <modal @close="$emit('close')">
        <template #title>{{ task.title }}</template>
        <template #content>
            <dl class="space-y-4 bg-white">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="flex items-center text-sm font-medium text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M7 8a3 3 0 100-6 3 3 0 000 6zM14.5 9a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM1.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 017 18a9.953 9.953 0 01-5.385-1.572zM14.5 16h-.106c.07-.297.088-.611.048-.933a7.47 7.47 0 00-1.588-3.755 4.502 4.502 0 015.874 2.636.818.818 0 01-.36.98A7.465 7.465 0 0114.5 16z" />
                        </svg>
                        <span class="ml-2">Assignee</span>
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <span v-for="(user, index) in task.assignedUsers" :key="index">
                            {{ user.name }}
                            <span v-if="index < task.assignedUsers - 1">, </span>
                        </span>
                    </dd>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="flex items-center text-sm font-medium text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2">Status</span>
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div
                            class="inline-flex rounded p-1 text-xs font-bold"
                            :class="`bg-${task.status.color}-100 text-${task.status.color}-500`"
                            v-if="task.status"
                        >
                            {{ task.status.name }}
                        </div>
                    </dd>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="flex items-center text-sm font-medium text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M3.5 2.75a.75.75 0 00-1.5 0v14.5a.75.75 0 001.5 0v-4.392l1.657-.348a6.449 6.449 0 014.271.572 7.948 7.948 0 005.965.524l2.078-.64A.75.75 0 0018 12.25v-8.5a.75.75 0 00-.904-.734l-2.38.501a7.25 7.25 0 01-4.186-.363l-.502-.2a8.75 8.75 0 00-5.053-.439l-1.475.31V2.75z" />
                        </svg>
                        <span class="ml-2">Priority</span>
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div
                            class="inline-flex rounded p-1 text-xs font-bold"
                            :class="`bg-${task.priority.color}-100 text-${task.priority.color}-500`"
                            v-if="task.priority"
                        >
                            {{ task.priority.name }}
                        </div>
                    </dd>
                </div>
            </dl>
            <div class="mt-6">
                <div class="text-sm font-medium text-gray-500 border-b border-gray-200 pb-2 mb-4">Description</div>
                <div class="text-sm font-medium text-gray-900">{{ task.description }}</div>

                <div class="mt-6">
                    <textarea id="comment" name="comment" v-model="form.comment" rows="3" placeholder="Comment on this task" class="mt-1 block w-full rounded-md border-transparent bg-gray-100 shadow-sm text-gray-900 focus:border-gray-300 focus:ring-gray-300 sm:text-sm"></textarea>
                </div>

                <div class="flex justify-end mt-2">
                    <VButton color="primary" @click="publishComment">Publish</VButton>
                </div>

                <div class="mt-6 space-y-4">
                    <div v-for="comment in task.comments.slice().reverse()" :key="comment.token">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                <div class="text-sm font-semibold text-gray-900">{{ comment.user.name }}</div>
                                <div class="text-xl font-medium text-gray-500">&#183;</div>
                                <div class="text-xs font-medium text-gray-500">{{ comment.createdAt }}</div>
                            </div>
                            <div class="p-1 cursor-pointer rounded text-gray-500 hover-bg-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                                </svg>
                            </div>
                        </div>
                        <!-- todo add user tags -->
                        <div class="mt-2 text-sm text-gray-500">
                            {{ comment.comment }}
                        </div>

                        <!--<div class="mt-3 ml-6">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                                    <div class="text-sm font-semibold text-gray-900">Orlando Diggs</div>
                                    <div class="text-xl font-medium text-gray-500">&#183;</div>
                                    <div class="text-xs font-medium text-gray-500">48 minutes ago</div>
                                </div>
                                <div class="p-1 cursor-pointer rounded text-gray-500 hover-bg-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-gray-500">
                                Alright
                                <span class="bg-primary-200 text-primary-500 font-semibold px-0.5 pb-0.5 rounded">@CandiceWu</span> ,
                                i'll be waiting.
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </template>
        <template #actions>
            <VButton color="white" @click="$emit('close')">Close</VButton>
        </template>
    </modal>
</template>

<script>
export default {
    name: "ShowTask",
    props: {
        task: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: {
                comment: null
            }
        }
    },
    methods: {
        async publishComment() {
            if (!this.form.comment) return;

            const {data} = await axios.post(`/api/task/${this.task.uuid}/comment`, this.form);
            this.task.comments.push(data.data);
            this.form.comment = null;
        }
    }
}
</script>
