<template>
    <div class="mb-3">
        <label>{{ input.label[lang()] }}</label>
        <jodit-vue
            v-model="value.value"
            :value="value.value"
        ></jodit-vue>
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
