<template>
    <div class="form-floating mb-3">
        <label class="form-label">{{ input.label[lang()] }}</label>
        <input type="date" class="form-control" v-model="value.value" :placeholder="input.label[lang()]">


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
                columna: null,
                cuit: null,
                disabled: false,
                domicilioFiscal: {},
            }
        },
        created() {

        },
        mounted () {},
      watch: {

      },
        methods: {

            lang() {
                return document.documentElement.lang
            }
        },
        computed: {
        }
    }

</script>
<style lang="css" scoped>
.form-label {
    margin-bottom: .5rem;
    font-weight: bold;
}
</style>
