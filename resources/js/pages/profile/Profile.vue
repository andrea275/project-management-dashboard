<template>
    <div class="max-w-4xl mx-auto">
        <UpdateProfile></UpdateProfile>
        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        <ChangePassword></ChangePassword>
    </div>
</template>

<script>
import ChangePassword from "./ChangePassword.vue";
import UpdateProfile from "./UpdateProfile.vue";

export default {
    name: "Profile",
    components: {
        ChangePassword,
        UpdateProfile
    }
}
</script>
