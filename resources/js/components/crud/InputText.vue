<template>
<span class="p-float-label">

        <InputText type="text"   v-model="value.value"   :id="value.value" />
        <label :for="value.value">{{ input.label[lang()] }}</label>

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
                return this.$parent.lang
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>
