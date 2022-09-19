<template>
    <div :class="classes">
        <slot></slot>
        <span class="text-xs font-semibold text-red-500" role="alert" v-if="error">{{ error }}</span>
    </div>

</template>

<script>
export default {
    name: "VDefaultField",
    props: {
        classes: String,
        error: String
    }
}
</script>
