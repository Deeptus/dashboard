<template>
    <div class="form-floating mb-3">
        <input :type="type" class="form-control" v-model="value.value" :placeholder="input.label[lang()]">
        <label>{{ input.label[lang()] }}</label>
    </div>
</template>
<script>

    export default {
        props: {
            input: {
                type: Object,
                default: {}
            },
            value: {
                type: Object,
                default: {}
            }
        },
        components: {},
        data(){
            return{
                type: 'date'
            }
        },
        created() {
            if (this.input && this.input.type) {
                if (this.input.type == 'datetime') {
                    this.type = 'datetime-local'
                }
            }
        },
        mounted () {},
        watch: {},
        methods: {
            lang() {
                return document.documentElement.lang
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>
