<template>
    <VueMultiselect
        :label="label"
        :track-by="trackBy"
        :options="options"
        :multiple="multiple"
        :closeOnSelect="closeOnSelect"
        :preselect-first="preselectFirst"
        :allow-empty="allowEmpty"
        :model-value="modelValue"
        @update:model-value="$emit('update:modelValue', $event)"
    ></VueMultiselect>
</template>

<script>
import VueMultiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

export default {
    name: "VMultiselect",
    components: { VueMultiselect },
    props: {
        options: {
            type: Array,
            default: () => []
        },
        trackBy: {
            type: String,
            required: true
        },
        label: {
            type: String,
            required: true
        },
        multiple: {
            type: Boolean,
            default: false
        },
        closeOnSelect: {
            type: Boolean,
            default: true
        },
        preselectFirst: {
            type: Boolean,
            default: false
        },
        allowEmpty: {
            type: Boolean,
            default: true
        },
        modelValue: {},
    }
}
</script>

<style lang="scss" scoped>
::v-deep .multiselect {
    &__placeholder {
        display: inline-block !important;
        margin-bottom: 0px !important;
        padding-top: 0px !important;
    }

    &__single {
        margin-bottom: 0px;
    }

    &__option--highlight {
        background: #3b82f6 !important;
    }

    &__option--highlight:after {
        background: #3b82f6 !important;
    }

    &__tags {
        padding: 5px !important;
        min-height: 10px;
    }

    &__placeholder{
        margin-left: 10px;
        margin-top: 2px;
    }

    &__tag {
        background: #3b82f6 !important;
        border: 1px solid #3b82f6 !important;
        color: white !important;
        margin-bottom: 0px !important;
        margin-right: 5px !important;
    }

    &__tag-icon:after {
        color: white !important;
    }

    &__tag-icon:focus,
    &__tag-icon:hover {
        background: transparent !important;
    }

    &__tag-icon:focus:after,
    &__tag-icon:hover:after {
        color: white !important;
    }
}
</style>
