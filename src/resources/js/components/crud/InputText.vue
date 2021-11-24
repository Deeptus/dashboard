<template>
    <div>
        <template v-if="input.translatable == 1">
            <div class="row">
                <div class="col" v-for="l in Object.keys(languages)" :key="l">
                    <div class="form-floating mb-3">
                        <textarea  style="height: 100px" class="form-control" v-model="value.value[l]" :placeholder="input.label[lang()]" v-if="input.type == 'textarea'"></textarea>
                        <input type="text" class="form-control" v-model="value.value[l]" :placeholder="input.label[lang()]" v-else>
                        <label>{{ input.label[lang()] }} - {{ l }}</label>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="form-floating mb-3">
                <textarea  style="height: 100px" class="form-control" v-model="value.value" :placeholder="input.label[lang()]" v-if="input.type == 'textarea'"></textarea>
                <input type="text" class="form-control" v-model="value.value" :placeholder="input.label[lang()]" v-else>
                <label>{{ input.label[lang()] }}</label>
            </div>
        </template>
    </div>
</template>
<script>

    export default {
        props: {
            input: {
                type: Object,
                default: {}
            },
            languages: {
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
            // if (typeof content.value === 'object' || content.value instanceof Object) {
            if ( this.input.translatable == 1 ) {
                if (Object.prototype.toString.call( this.value.value ) !== '[object Object]') {
                    this.value.value = {}
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
