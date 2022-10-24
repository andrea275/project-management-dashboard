<template>
    <textarea
        rows="3"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
        :class="{'border-red-500': !!error}"
        :id="id"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    ></textarea>
</template>

<script>
export default {
    name: "VTextarea",
    emits: ['update:modelValue'],
    props: {
        error: String,
        id: String,
        placeholder: String,
        modelValue: String,
    }
}
</script>
