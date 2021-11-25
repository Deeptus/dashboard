<template>
    <div class="mb-3">
        <template v-if="input.translatable == 1">
            <div class="block-translations">
                <div class="row">
                    <div class="col" v-for="l in Object.keys(languages)" :key="l">
                        <label>{{ input.label[lang()] }} - {{ l }}</label>
                        <jodit-vue
                            v-model="value.value[l]"
                            :value="value.value[l]"
                        ></jodit-vue>
                    </div>
                </div>
                <button type="button" class="badge bg-secondary block-translations__btn" @click="translate()">Traducir</button>
            </div>
        </template>
        <template v-else>
            <label>{{ input.label[lang()] }}</label>
            <jodit-vue
                v-model="value.value"
                :value="value.value"
            ></jodit-vue>
        </template>
    </div>
</template>
<script>
    import 'jodit/build/jodit.min.css'
    import { JoditEditor } from 'jodit-vue'

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
        components: {
            'jodit-vue': JoditEditor
        },
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
            },
            translate() {
                this.$root.translate(JSON.stringify(this.value.value)).then(response => {
                    this.value.value = response.data
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