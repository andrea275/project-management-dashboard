<template>
    <modal @close="$emit('close')">
        <template #title>Add User</template>
        <template #content>
            <div class="space-y-6 bg-white">
                <div class="grid grid-cols-6 gap-6">
                    <VDefaultField
                        classes="col-span-6 space-y-1"
                        :error="errors.get('name')"
                    >
                        <VLabel labelFor="name">Name</VLabel>
                        <VInput
                            id="name"
                            :error="errors.get('name')"
                            v-model="form.name"
                            @input="errors.clear('name')"
                        ></VInput>
                    </VDefaultField>

                    <VDefaultField
                        classes="col-span-6 space-y-1"
                        :error="errors.get('email')"
                    >
                        <VLabel labelFor="email">Email</VLabel>
                        <VInput
                            id="email"
                            :error="errors.get('email')"
                            v-model="form.email"
                            @input="errors.clear('email')"
                        ></VInput>
                    </VDefaultField>

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
            <VButton color="primary" @click="saveUser">Create</VButton>
        </template>
    </modal>
</template>

<script>
import Errors from "../../../helpers/Errors";

export default {
    name: "SaveUser",
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
                name: null,
                email: null,
                isAdmin: false
            },
            errors: new Errors()
        }
    },
    methods: {
        async saveUser() {
            try {
                await axios.post(`/api/project/${this.projectSlug}/user`, this.form);
                this.$emit('close');

                toastr.success('User added successfully!');
            } catch (errors) {
                if (errors.response.status === 422) {
                    this.errors.record(errors.response.data.errors);
                    return;
                }

                toastr.success('An error occurred!');
            }
        }
    }
}
</script>
