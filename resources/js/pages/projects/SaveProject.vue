<template>
    <modal @close="$emit('close')">
        <template #title>Create Project</template>
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
import Errors from "../../helpers/Errors";

export default {
    name: "SaveProject",
    emits: ['close', 'saved'],
    data() {
        return {
            form: {
                title: null,
                description: null
            },
            errors: new Errors()
        }
    },
    methods: {
        async saveTask() {
            try {
                const {data} = await axios.post(`/api/project`, this.form);
                this.$emit('saved', data.data);

                toastr.success('Project created successfully!');
            } catch (errors) {
                if (errors.response.status === 422) {
                    this.errors.record(errors.response.data.errors);
                    return;
                }

                toastr.error('An error occurred!');
            }
        }
    }
}
</script>
