<template>
    <div class="mb-3">
        <template v-if="input.translatable == 1">
            <div class="row">
                <div class="col" v-for="l in Object.keys(languages)" :key="l">
                    <label>{{ input.label[lang()] }} - {{ l }}</label>
                    <jodit-vue
                        v-model="value.value[l]"
                        :value="value.value[l]"
                    ></jodit-vue>
                </div>
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
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>
