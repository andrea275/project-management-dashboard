<template>
    <modal @close="$emit('close')">
        <template #title>Update User</template>
        <template #content>
            <div class="space-y-6 bg-white">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 font-semibold text-gray-900">
                        {{ user.name }} ({{ user.email }})
                    </div>

                    <div class="col-span-6">
                        <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
                            <input type="checkbox" value="" id="default-toggle" class="sr-only peer" v-model="form.isAdmin">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900">Admin</span>
                        </label>
                    </div>
                </div>
            </div>
        </template>
        <template #actions>
            <VButton color="white" @click="$emit('close')">Cancel</VButton>
            <VButton color="primary" @click="saveUser">Send</VButton>
        </template>
    </modal>
</template>

<script>

export default {
    name: "UpdateUser",
    emits: ['close', 'updated'],
    props: {
        projectSlug: {
            type: String,
            required: true
        },
        user: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: {
                isAdmin: false
            }
        }
    },
    mounted() {
        this.form.isAdmin = !!this.user.isAdmin;
    },
    methods: {
        async saveUser() {
            try {
                const {data} = await axios.put(`/api/project/${this.projectSlug}/user/${this.user.token}`, this.form);
                this.$emit('updated', data.data);

                toastr.success('User updated successfully!');
            } catch (errors) {
                toastr.error('An error occurred!');
            }
        }
    }
}
</script>
