<template>
    <div v-if="state == 'show'">
        <template v-if="input.translatable == 1">
            <div class="block-translations">
                <div class="row">
                    <div class="col" v-for="l in Object.keys(languages)" :key="l">
                        <div class="form-floating mb-3">
                            <textarea  style="height: 100px" class="form-control" v-model="value.value[l]" :placeholder="input.label[lang()]" v-if="input.type == 'textarea'"></textarea>
                            <input type="text" class="form-control" v-model="value.value[l]" :placeholder="input.label[lang()]" v-else>
                            <label>{{ input.label[lang()] }} - {{ l }}</label>
                        </div>
                    </div>
                </div>
                <button type="button" class="badge bg-secondary block-translations__btn" @click="translate()" v-if="permissions.enableButtonTranslate">Traducir</button>
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
                state: ''
            }
        },
        created() {
            // if (typeof content.value === 'object' || content.value instanceof Object) {
            if ( this.input.translatable == 1 ) {
                if (Object.prototype.toString.call( this.value.value ) !== '[object Object]') {
                    this.$set(this.value, 'value', {})
                }
            }
            this.state = 'show'
        },
        mounted () {},
        watch: {},
        methods: {
            lang() {
                return document.documentElement.lang
            },
            translate() {
                this.$root.translate(this.value.value[this.lang()]).then(response => {
                    Object.keys(response.data).forEach(key => {
                        this.$set(this.value.value, key, response.data[key])
                        this.$forceUpdate()
                    })
                })
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>
    .block-translations {
        position: relative;
        &__btn {
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0.5;
            font-size: 9px;
            padding: 2.5px 5px;
        }
    }
</style>
