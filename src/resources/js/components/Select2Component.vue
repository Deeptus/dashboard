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
        },
        watch: {
            value: function (value) {
                if ([...value].sort().join(",") !== [...$(this.$el).val()].sort().join(","))
                    $(this.$el).val(value).trigger('change');
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
<style lang="scss" scoped>
    html, body {
      font: 13px/18px sans-serif;
    }
    select {
      width: 100%;
    }
</style>