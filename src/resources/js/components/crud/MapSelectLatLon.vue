<template>
    <fieldset class="mb-3">
        <legend>{{ input.label[lang()] }}:</legend>
        <CargarMapa
            :position="position"
            class="mb-2"
            apiKey="AIzaSyAZUlidy4Exa3bvZLRh4qgqx4lwlLy6khw"
        ></CargarMapa>
        <div class="row">
            <div class="col-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" v-model="position.lat">
                    <label>Latitude</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" v-model="position.lng">
                    <label>Longitude</label>
                </div>
            </div>
        </div>
    </fieldset>
</template>
<script>
    import CargarMapa from "./CargarMapa";

    export default {
        name:"MapSelectLatLon",
        props: {
            input: {
                type: Object,
                default: {}
            },
            value: {
                default: {}
            }
        },
        components: {
            CargarMapa
        },
        data(){
            return{
                position: {
                    lat: '',
                    lng: ''
                }
            }
        },
        created() {
            this.position.lat = this.value.value.lat
            this.position.lng = this.value.value.lng
        },
        mounted () {},
        watch: {
            position: {
                deep: true,
                handler() {
                    this.value.value.lat = this.position.lat
                    this.value.value.lng = this.position.lng
                }
            }
        },
        methods: {
            lang() {
                return document.documentElement.lang
            }
        },
        computed: {}
    }

</script>
<style lang="scss" scoped>

</style>