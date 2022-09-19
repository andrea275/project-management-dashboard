<template>
    <label :for="labelFor" class="block text-sm font-medium text-gray-700">
        <slot></slot>
        <sup class="text-primary-500" v-if="required">*</sup>
    </label>
</template>

<script>
export default {
    name: "VLabel",
    props: {
        labelFor: {
            type: String,
            required: true
        },
        required: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>

</style>
