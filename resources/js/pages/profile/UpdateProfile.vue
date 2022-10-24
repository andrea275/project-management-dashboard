<template>
    <div class="flex justify-center" v-if="!user">
        <Loader size="small"></Loader>
    </div>
    <div v-else>
        <div class="mt-5 md:mt-0">
            <form action="#" method="POST">
                <div class="border shadow-md sm:overflow-hidden sm:rounded-md">
                    <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                        <div class="grid grid-cols-3 gap-6">
                            <VDefaultField
                                classes="col-span-3 sm:col-span-2"
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
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Photo</label>
                            <div class="mt-1 flex items-center">
                                    <span class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100">
                                        <img
                                            class="w-full h-full rounded-full"
                                            :src="user.image"
                                            :alt="user.name"
                                            :title="user.name"
                                            v-if="user.image"
                                        >
                                        <div class="inline-flex overflow-hidden relative justify-center items-center w-full h-full bg-gray-100 rounded-full dark:bg-gray-600" :title="user.name" v-else>
                                            <span class="font-medium text-gray-600 dark:text-gray-300 text-base">
                                                {{ getFirstLetters(user.name) }}
                                            </span>
                                        </div>
                                    </span>
                                <VButton color="primary" class="ml-5" @click="changeImage">Change</VButton>
                                <input type="file" ref="image" @change="uploadImage" class="hidden" accept=".jpg,.jpeg,.png">
<!--                                <button type="button" class="ml-5 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Change</button>-->
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                        <VButton color="primary" @click="updateProfile">Save</VButton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Errors from "../../helpers/Errors";
import helpers from "../../mixins/helpers";

export default {
    name: "UpdateProfile",
    mixins: [helpers],
    data() {
        return {
            form: {
                name: null
            },
            user: null,
            errors: new Errors()
        }
    },
    mounted() {
        this.fetchUser();
    },
    methods: {
        async fetchUser() {
            const {data} = await axios.get(`/api/user`);
            this.user = data.data;
            this.form.name = this.user.name;
        },
        async updateProfile() {
            try {
                let form = new FormData();
                form.append('name', this.form.name);
                form.append('image', this.form.image || '');
                form.append('_method', 'PUT');

                await axios.post(`/api/user/profile`, form);
                toastr.success('Profile updated successfully!');
            } catch (errors) {
                if (errors.response.status === 422) {
                    this.errors.record(errors.response.data.errors);
                    return;
                }

                toastr.error('An error occurred!');
            }
        },
        changeImage() {
          this.$refs.image.click();
        },
        uploadImage(event) {
            this.errors.clear('image');
            this.form.image = event.target.files[0];

            const file = event.target.files[0];

            let reader = new FileReader();

            reader.onload = (e) => {
                this.user.image = e.target.result;
            }

            reader.readAsDataURL(file);
        }
    }
}
</script>
