<template>
    <fieldset class="mb-3" v-if="display">
        <legend>{{ input.label[this.lang()] }}:</legend>
        <div v-for="(item, key) in items" :key="key">
            <div class="subform">
                <div class="subform__buttons-left d-flex flex-column">
                    <button class="btn btn-danger my-1" @click="removeItem(key)"><i class="fas fa-trash"></i></button>
                    <button class="btn btn-warning my-1" @click="copyItem(key)"><i class="fas fa-copy"></i></button>
                </div>
                <div class="row subform__row">
                    <InputLayout :languages="languages" :content="item" :relations="relations" :subForm="{}" :value="item.content[input.columnname]" :input="input" v-for="(input, inputk) in subForm[input.columnname].inputs" :key="inputk"></InputLayout>
                </div>
                <div class="subform__buttons-right">
                    <button @click="moveUp(key)" class="btn btn-warning" v-if="key > 0"><i class="fas fa-angle-up"></i></button>
                    <button @click="moveDown(key)" class="btn btn-warning subform___button-down" v-if="key < ( items.length - 1 )"><i class="fas fa-angle-down"></i></button>
                </div>
            </div>
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
            languages: {
                default: {}
            }
        },
        components: {
        },
        data(){
            return{
                display: true,
                items: [],
                inputs: []
            }
        },
        created() {
            // console.log(this.value);
            // aca hay un error porque llega primero como un objeto, pero en su lugar deberia llegar como un array
            this.inputs = this.subForm[this.input.columnname].inputs
            this.items = Array.isArray(this.value.value) ? this.value.value : []
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
                    if (input.type == 'multimedia_file') {
                        this.$set(newItem.content[input.columnname], 'value', {
                            // id: 0,
                            path: '',
                            type: '',
                            url: ''
                        })
                    } else {
                        this.$set(newItem.content[input.columnname], 'value', input.default)
                    }
                    this.$set(newItem.content[input.columnname], 'errors', [])
                });
                if ( !Array.isArray(this.items) ) {
                    this.items = []
                }
                this.items.push(newItem)
                console.log(this.items)
            },
            removeItem(index) {
                this.items.splice(index, 1)
            },
            copyItem(index) {
                let newItem = JSON.parse(JSON.stringify(this.items[index]))
                delete newItem.content.id
                this.items.splice(index + 1, 0, newItem)
            },
            move(array, index, delta) {
                this.display = false
                this.$nextTick().then(() => {
                    var newIndex = index + delta;
                    if (newIndex < 0 || newIndex == array.length) return; //Already at the top or bottom.
                    var indexes = [index, newIndex].sort((a, b) => a - b); //Sort the indixes (fixed)
                    array.splice(indexes[0], 2, array[indexes[1]], array[indexes[0]]); //Replace from lowest index, two elements, reverting the order

                    this.display = true
                });
            },
            moveUp(index) {
                this.move(this.items, index, -1);
            },
            moveDown(index) {
                this.move(this.items, index, 1);
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>
    .subform {
        display: flex;
        &__row {
            flex-grow: 1;
        }
        &__buttons-left {
            padding-top: 23px;
            padding-right: 15px;
        }
        &__buttons-right {
            padding-left: 15px;
            display: flex;
            flex-direction: column;
        }
        &___button-down {
            margin-top: auto;
            margin-bottom: 4px;
        }
    }
</style>