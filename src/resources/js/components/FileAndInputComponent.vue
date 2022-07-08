<template>
    <fieldset class="fichas-fieldset">
        <legend>{{ label }}</legend>
            <draggable v-model="fichas" class="row" draggable=".draggable-item">
                <div class="col-md-12 col-lg-6 col-xl-4 draggable-item" v-for="(item, index) in fichas" :key="index">
                    <fieldset class="ficha-item-fieldset">
                        <div class="ficha-item-controls">
                            <button type="button" class="btn btn-danger" @click="deleteFicha(index)"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        <legend>{{ legendFichaProducto(index) }}</legend>
                        <div class="row">
                            <div class="col-md-12 mb-2 mt-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" :id="'customFileLangHTML'+index" @change="onFileFicha($event, index)">
                                    <label class="custom-file-label" :for="'customFileLangHTML'+index" data-browse="Seleccione">{{ fileFichaName(index) }}</label>
                                </div>
                            </div>
                            <div v-for="(languageKey, langIndex) in lang" :key="langIndex" class="col-md-6">
                                <fieldset>
                                    <legend>{{ languages[languageKey] }}</legend>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label :for="'nombre-'+languageKey">Nombre</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                :id="'nombre-'+index+'-'+languageKey"
                                                :name="'nombre-'+index+'-'+languageKey"
                                                v-model="item.nombre[languageKey]"
                                            >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label :for="'descripcion-'+languageKey">Descripción</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                :id="'descripcion-'+index+'-'+languageKey"
                                                :name="'descripcion-'+index+'-'+languageKey"
                                                v-model="item.descripcion[languageKey]"
                                            >
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </draggable>
            <div class="fichas-controls">
                <button type="button" class="btn btn-success" @click="addFicha()"><i class="fas fa-plus"></i> Añadir</button>
            </div>
    </fieldset>
</template>
<script>
    import draggable from 'vuedraggable'
    var publicPATH = document.head.querySelector('meta[name="public-path"]').content;
    export default {
        props: {
            model: {
                type: Array,
            },
            languages: {
                type: Object,
            },
            label: {
                type: String,
                default: 'FICHAS DEL PRODUCTO'
            },
            lang: {
                type: Array,
            },
            /*id: {
                type: String,
                default: ''
                // default: Math.random().toString(36).substring(2)
            },*/
        },
        components: {
            draggable,
        },
        data(){
            return{
                fichas: [],
                id: ''
            }
        },
        created() {
            this.fichas = JSON.parse(JSON.stringify(this.model || []))
        },
        mounted () {
            this.id = this._uid.toString() + Math.random().toString(36).substring(2)
        },
        watch: {
            fichas: function(val, oldVal) {
                this.$emit('update:model', this.fichas || [])
            }
        },
        methods: {
            onFileFicha(e, index){
                this.fichas[index].file = e.target.files[0]
                return true
            },
            legendFichaProducto(index) {
                if (this.fichas[index].nombre.es) {
                    return this.fichas[index].nombre.es;
                }
                return 'Ficha'
            },
            fileFichaName(index) {
                if (this.fichas[index].file.name) {
                    return this.fichas[index].file.name;
                }
                if (this.fichas[index].file.path) {
                    return this.fichas[index].file.path.split('\/').pop();
                }
                return 'Ningún archivo seleccionado'
            },
            deleteFicha(index) {
                this.fichas.splice(index, 1);
            },
            addFicha() {
                this.fichas.push({
                    file: {
                        url: '',
                        path: '',
                        type: ''
                    },
                    nombre: {},
                    descripcion: {},
                });
            },
        }
  }
</script>
<style lang="scss" scoped>
    .gallery-item {
        position: relative;
        width: 100%;
        margin-bottom: 5px;
    }
    .gallery-item-controls {
        position: absolute;
        right: 0;
        top: 0;
    }
    .gallery-item-container{
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2px;
        border: solid 1px #CCC;
        img {
            max-width: 100%;
            max-height: 100%;
        }
    }
    .gallery-item-overlay {
        padding-bottom: 100%;
    }
    .gallery-item-path {
        position: absolute;
        width: 100%;
        font-size: 12px;
        line-height: 14px;
        border-top: 1px solid #000;
        padding: 2px 5px 4px 5px;
        background-color: #00000085;
        color: aliceblue;
        transition: .2s bottom;
    }
    .draggable-item {
        cursor: move;
        overflow: hidden;
        &:hover .gallery-item-path {
            bottom: 0;
            margin-top: 0;
        }
    }
    .fichas-fieldset {
        padding-bottom: 60px;
        position: relative;
        .fichas-controls {
            position: absolute;
            right: 0;
            bottom: 0;
        }
    }
    .ficha-item-fieldset {
        position: relative;
        .ficha-item-controls {
            position: absolute;
            right: 0;
            top: 12px;
        }
    }
    .custom-file-label {
        overflow: hidden;
    }
</style>