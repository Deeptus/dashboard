<template>
    <div class="mb-3" v-if="state == 'show'">
        <template v-if="input.translatable == 1">
            <div class="block-translations">
                <div class="row">
                    <div class="col-12 mt-2" v-for="l in Object.keys(languages)" :key="l">
                        <label>{{ input.label[lang()] }} - {{ l }}</label>
                        <jodit-vue
                            v-model="value.value[l]"
                            :value="value.value[l]"
                            :buttons="jodit.buttons"
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
                :buttons="jodit.buttons"
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
                state: '',
                jodit: {
                    buttons: []
                }
            }
        },
        created() {
                this.jodit.buttons = [
		{
			group: 'font-style',
			buttons: []
		},
		{
			group: 'list',
			buttons: []
		},
		{
			group: 'indent',
			buttons: []
		},
		{
			group: 'font',
			buttons: []
		},
		{
			group: 'color',
			buttons: []
		},
		'---',
		{
			group: 'script',
			buttons: []
		},
		{
			group: 'media',
			buttons: []
		},
		'\n',
		{
			group: 'state',
			buttons: []
		},
		{
			group: 'clipboard',
			buttons: []
		},
		{
			group: 'insert',
			buttons: []
		},
		{
			group: 'form',
			buttons: []
		},
		'---',
		{
			group: 'history',
			buttons: []
		},
		{
			group: 'search',
			buttons: []
		},
		{
			group: 'source',
			buttons: []
		},
		{
			group: 'other',
			buttons: []
		},
		{
			group: 'info',
			buttons: []
		},

                    '|',
                    '\n',
                    {
                        name: 'Imagen',
                        exec: (editor) => {
                            this.selectFile(editor)
                        }
                    },
                ]
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
            async selectFile(editor) {
                await this.fileManager().open().then((callback) => {
                    if (callback) {
                        editor.selection.insertHTML('<img src="' + callback.url + '" alt="">')
                    }
                })
            },
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