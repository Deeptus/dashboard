<template>
<span class="p-float-label">
        <InputText type="text" class="p-inputtext-lg"   v-model="value.value"   :id="value" />
        <label for="value">{{ input.label[lang()] }}</label>
</span>
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
