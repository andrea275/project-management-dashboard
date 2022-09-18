<template>
    <button
        :type="type"
        class="inline-flex w-full justify-center rounded-md border px-4 py-2 text-base font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto sm:text-sm"
        :class="classes"
        @click="$emit('click')"
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "VButton",
    emits: ['click'],
    props: {
        type: {
            type: String,
            default: 'button'
        },
        color: {
            type: String,
            default: 'primary',
            validator(value) {
                return ["primary", "white"].includes(value)
            }
        }
    },
    computed: {
        classes() {
            if (this.color  === 'primary')
                return "border-transparent bg-primary-600 text-white hover:bg-primary-700";

            return "border-gray-300 bg-white text-gray-700 hover:bg-gray-50";
        }
    }
}
</script>

<style scoped>

</style>
