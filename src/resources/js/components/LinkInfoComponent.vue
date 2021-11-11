<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <fieldset>
                <legend>{{ legend }}</legend>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th v-if="icon">Ícono</th>
                                    <th>Texto a mostrar</th>
                                    <th>Enlace</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in data" :key="index">
                                    <td style="width: 1px">
                                        <button @click="removeItem(index)" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                    <td v-if="icon">
                                        <input
                                            type="email"
                                            class="form-control"
                                            :id="'item.icon'"
                                            :name="'item.icon'"
                                            v-model="item.icon"
                                        >
                                    </td>
                                    <td>
                                        <input
                                            type="email"
                                            class="form-control"
                                            :id="'item.text'"
                                            :name="'item.text'"
                                            v-model="item.text"
                                        >
                                    </td>
                                    <td>
                                        <input
                                            type="email"
                                            class="form-control"
                                            :id="'item.link'"
                                            :name="'item.link'"
                                            v-model="item.link"
                                            placeholder="https://www.com/, mailto:, tel:"
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td :colspan="cols">
                                        <button @click="addItem" class="btn btn-primary btn-block">
                                            <i class="fas fa-plus"></i> Añadir
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['model', 'legend', 'icon'],
        components: {
        },
        data(){
            return{
                data: [],
                cols: 3
            }
        },
        watch: {
            data: {
                handler(val){
                    this.$emit('update:model', JSON.stringify(val || []))
                },
                deep: true
            }
        },
        created() {
            this.$nextTick(() => {
                if (this.icon) {
                    this.cols++
                }
                if (this.model instanceof Array) {
                    this.data = this.model
                }
                if (typeof this.model === 'string' || this.model instanceof String) {
                    let convertData = false
                    try {
                        convertData = JSON.parse(this.model)
                    } catch (e) {
                        convertData = false;
                    }
                    if (convertData instanceof Array) {
                        this.data = convertData
                    }
                }
            });
        },
        updated: function () {
            this.$nextTick(function () {
            })
        },
        methods: {
            addItem() {
                let layout = {
                    text: '',
                    link: ''
                }
                if (this.icon == true) {
                    layout = {
                        icon: '',
                        text: '',
                        link: ''
                    }
                }
                this.data.push(layout)
            },
            removeItem(index) {
                this.data.splice(index, 1);
            }
        },
        computed: {
        }
    }
</script>
<style lang="scss" scoped>

</style>
