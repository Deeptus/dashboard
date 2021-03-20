<template>
    <div class="p-d-block p-mt-4 p-mb-3 p-mx-auto">
        <ToggleButton v-model="selected" :onLabel="input.label[lang()]" :offLabel="input.label[lang()]"
         onIcon="pi pi-check" offIcon="pi pi-times" />

    </div>
</template>
<script>

    export default {
        props: {
            input: {
                type: Object,
                default: {}
            },
            relations: {
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
                selected: false,
                options: [],
                optionsA: [],                
                mode: this.input.valueoriginselector
            }
        },
        created() {


            //this.value.value = this.input.default
            console.log(this.value.value)
            if(this.value.value == 1){
                this.selected = true
            }

        },
        mounted () {



        },
        watch: {
            selected(val){
                console.log(val)
                this.value.value = val
            }

        },
        methods: {
            setSelect(event){
                    console.log(event)
                    
                    this.value.value = event
            },
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
