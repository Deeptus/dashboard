<template>
<span class="p-float-label">

        <InputText type="text"   v-model="val.value"   :id="input.columnname" style="width: 100%" />
        <label :for="input.columnname">{{ input.label[lang()] }}</label>

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
                val: this.value
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
