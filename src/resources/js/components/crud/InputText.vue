<template>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" v-model="value.value" :placeholder="input.label[lang()]">
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
            }
        },
        created() {
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
