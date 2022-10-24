<template>
    <input
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
        :class="{'border-red-500': !!error}"
        :type="type"
        :id="id"
        :placeholder="placeholder"
        :disabled="disabled"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>

<script>
export default {
    name: "VInput",
    emits: ['update:modelValue'],
    props: {
        type: {
            type: String,
            default: 'text'
        },
        disabled: {
            type: Boolean,
            default: false
        },
        error: String,
        id: String,
        placeholder: String,
        modelValue: String,
    }
}
</script>
