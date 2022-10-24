<template>
    <div>
        <div class="mt-5 md:mt-0">
            <form action="#" method="POST">
                <div class="border shadow-md sm:overflow-hidden sm:rounded-md">
                    <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Password</h3>
                        <div class="grid grid-cols-3 gap-6">
                            <VDefaultField
                                classes="col-span-3 sm:col-span-2"
                                :error="errors.get('currentPassword')"
                            >
                                <VLabel labelFor="currentPassword">Current Password</VLabel>
                                <VInput
                                    id="currentPassword"
                                    type="password"
                                    :error="errors.get('currentPassword')"
                                    v-model="form.currentPassword"
                                    @input="errors.clear('currentPassword')"
                                ></VInput>
                            </VDefaultField>

                            <VDefaultField
                                classes="col-span-3 sm:col-span-2"
                                :error="errors.get('password')"
                            >
                                <VLabel labelFor="password">New Password</VLabel>
                                <VInput
                                    id="password"
                                    type="password"
                                    :error="errors.get('password')"
                                    v-model="form.password"
                                    @input="errors.clear('password')"
                                ></VInput>
                            </VDefaultField>

                            <VDefaultField
                                classes="col-span-3 sm:col-span-2"
                                :error="errors.get('password_confirmation')"
                            >
                                <VLabel labelFor="password_confirmation">Confirm Password</VLabel>
                                <VInput
                                    id="password_confirmation"
                                    type="password"
                                    :error="errors.get('password_confirmation')"
                                    v-model="form.password_confirmation"
                                    @input="errors.clear('password_confirmation')"
                                ></VInput>
                            </VDefaultField>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <VButton color="primary" @click="savePassword">Save</VButton>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Errors from "../../helpers/Errors";

export default {
    name: "ChangePassword",
    data() {
        return {
            form: {
                currentPassword: null,
                password: null,
                password_confirmation: null,
            },
            errors: new Errors()
        }
    },
    methods: {
        async savePassword() {
            try {
                await axios.put(`/api/user/password`, this.form);
                toastr.success('Password changed successfully!');
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
