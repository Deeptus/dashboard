<template>
    <select class="js-example-basic-multiple js-states form-control w-100" :multiple="multiple">
        <slot></slot>
    </select>
</template>
<script>
    import 'select2/dist/css/select2.min.css'
    import select2 from 'select2'

    export default {
        props: {
            options: null,
            value: null,
            multiple: false,
        },
        components: {
            select2,
        },
        mounted: function () {
            var vm = this
            $(this.$el)
            .select2({ data: this.options })
            .val(this.value)
            .trigger('change')
            .on('change', function () {
                vm.$emit('input', $(this).val())
            })
            .on('select2:open', () => {
                const input = document.querySelector('input.select2-search__field')
                if (input) {
                    input.focus()
                }
            })
        },
        watch: {
            value: function (value) {
                console.log(value)
                this.$emit('update:value', value)
                if ([...value].sort().join(",") !== [...$(this.$el).val()].sort().join(",")) {
                    $(this.$el).val(value).trigger('change')
                }
            },
            options: function (options) {
                $(this.$el).empty().select2({ data: options })
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    }
</script>
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-container .select2-selection--single {
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        display: flex;
        align-items: center;
        border-radius: 0;
        border: 1px solid #cbc8d0;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
    }
    .select2-selection--multiple {
        height: 58px !important;
        padding-top: 20px !important;
        padding-left: 8px !important;
        border-radius: 0 !important;
        border: 1px solid #cbc8d0 !important;
    }
</style>