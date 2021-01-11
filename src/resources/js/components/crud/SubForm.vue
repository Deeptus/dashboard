<template>
    <fieldset class="mb-3">
        <legend>{{ input.label[this.lang()] }}:</legend>
        <div class="row" v-for="(item, key) in items" :key="key">
            <InputLayout :relations="{}" :subForm="{}" :value="item.content[input.columnname]" :input="input" v-for="(input, inputk) in subForm[input.columnname].inputs" :key="inputk"></InputLayout>
            <hr class="mt-0">
        </div>
        <div class="d-sm-flex align-items-center justify-content-center mt-3">
            <button type="button" @click="addItem()" class="btn btn-secondary">
                <i class="fas fa-plus fa-sm text-white-50"></i>
                Añadir
            </button>
        </div>

    </fieldset>
</template>
<script>

    export default {
        name:"SubForm",
        props: {
            input: {
                type: Object,
                default: {}
            },
            relations: {
                default: {}
            },
            subForm: {
                default: {}
            },
            value: {
                default: {}
            },
        },
        components: {
        },
        data(){
            return{
                items: [],
                inputs: []
            }
        },
        created() {
            this.inputs = this.subForm[this.input.columnname].inputs
            this.items = this.value.value ?? []
            let newItem = {
                content: {}
            }
            if(this.subForm[this.input.columnname].content) {
                this.subForm[this.input.columnname].content.forEach(contentItem => {
                    let newItem = {
                        content: {}
                    }
                    Object.keys(contentItem).forEach(key => {
                        newItem.content[key] = {
                            value: contentItem[key],
                            errors: []
                        }
                    });
                    this.items.push(newItem)
                });
            }
            this.mapItems()
        },
        mounted () {},
        watch: {
            items: {
                deep: true,
                handler() {
                    this.value.value = this.items
                }
            }
        },
        methods: {
            lang() {
                return document.documentElement.lang
            },
            mapItems() {
                if (Object.prototype.toString.call( this.items ) == '[object Array]') {
                    this.items.forEach(item => {
                        this.subForm[this.input.columnname].inputs.forEach(input => {
                            if (!item.content[input.columnname]) {
                                item.content[input.columnname] = {}
                                this.$set(item.content[input.columnname], 'value', '')
                                this.$set(item.content[input.columnname], 'errors', [])
                            }
                        });
                    });
                } else {
                    this.items = []
                }
            },
            addItem() {
                this.inputs = this.subForm[this.input.columnname].inputs
                let newItem = {
                    content: {}
                }
                this.inputs.forEach(input => {
                    newItem.content[input.columnname] = {}
                    this.$set(newItem.content[input.columnname], 'value', input.default)
                    this.$set(newItem.content[input.columnname], 'errors', [])
                });
                if ( !Array.isArray(this.items) ) {
                    this.items = []
                }
                this.items.push(newItem)
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>

</style>