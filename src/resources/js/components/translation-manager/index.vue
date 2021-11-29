<template>
    <div class="translation-manager">
        <div v-if="componentState == 'loading'" class="loading-overlay">
            <i class="fa fa-spinner fa-spin"></i>
        </div>
        <div v-if="componentState == 'saving'" class="loading-overlay">
            <i class="fa fa-spinner fa-spin"></i>
            Guardando...
        </div>
        <div v-if="componentState == 'loaded'" class="translation-manager__content">
            <div class="translation-manager__header">
                <div class="translation-manager__header-title">
                    <h3>{{ __('Translation Manager') }}</h3>
                </div>
                <div class="translation-manager__header-buttons text-right">
                    <button class="btn btn-sm btn-primary" @click="saveTranslations()"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    <button class="btn btn-sm btn-primary" @click="messageInConstruction()"><i class="fas fa-file-export"></i> {{ __('Export') }}</button>
                    <button class="btn btn-sm btn-primary" @click="messageInConstruction()"><i class="fas fa-file-import"></i> {{ __('Import') }}</button>
                    <button class="btn btn-sm btn-warning" @click="displayTrash = !displayTrash">
                        <i class="fa fa-trash"></i>
                        {{ displayTrash ? 'Hide' : 'Show' }} Trash
                    </button>
                </div>
            </div>
            <div class="translation-manager__body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>KEY</th>
                            <th v-for="(lang_key, index) in langs_keys" :key="index">
                                {{ langs[lang_key].name }}
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(translation, index) in translations" >
                            <tr :key="index" v-if="!translation.deleted_at || displayTrash" :class="{'table-warning': translation.deleted_at}">
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="translation.key" @blur="keySlug(translation)">
                                        <button class="btn btn-outline-secondary" @click="keySlug(translation)"><i class="fas fa-plug"></i></button>
                                    </div>
                                </td>
                                <td v-for="(lang_key, index) in langs_keys" :key="index">
                                    <input type="text" class="form-control" v-model="translation.translation[lang_key]">
                                </td>
                                <td>
                                    <button class="btn btn-secondary"
                                        @click="translate(translation)">
                                        <i class="fas fa-language"></i>
                                    </button>
                                    <button class="btn btn-danger"
                                        @click="removeTranslation(index)"
                                        v-if="!translation.deleted_at">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button class="btn btn-success"
                                        @click="restoreTranslation(index)"
                                        v-if="translation.deleted_at">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td :colspan="langs_keys.length + 2" class="text-center">
                                <button class="btn btn-success" @click="addTranslation()">
                                    <i class="fas fa-plus"></i> Añadir
                                </button>
                                <button class="btn btn-primary" @click="saveTranslations()">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {},
        components: {},
        data(){
            return{
                langs: {},
                langs_keys: [],
                translations: [],
                current_lang: '',
                displayTrash: false,
                componentState: 'loading',
            }
        },
        created() {
            this.$nextTick(() => {
                axios.get(window.apis.translation_manager)
                    .then(response => {
                        this.langs        = response.data.langs
                        this.langs_keys   = response.data.langs_keys
                        this.translations = response.data.translations
                        this.current_lang = response.data.current_lang
                        this.componentState = 'loaded'
                    })
                    .catch(error => {
                        console.log(error);
                    });
            });
        },
        mounted () {},
        watch: {},
        methods: {
            __(key){
                return key
            },
            translate(translation) {
                this.$root.translate(translation.translation[this.current_lang]).then(response => {
                    this.langs_keys.forEach(lang_key => {
                        this.$set(translation.translation, lang_key, response.data[lang_key])
                    });
                    if (translation.key == '') {
                        // get index
                        let index = this.translations.indexOf(translation)
                        // detect pattern two previous keys, compare and extract similarity
                        let prefix = []
                        let default_prefix = ''
                        if (index > 1) {
                            prefix.push(this.translations[index - 1].key.split('-')[0])
                            prefix.push(this.translations[index - 2].key.split('-')[0])
                            // remove duplicates
                            prefix = prefix.filter((item, index) => {
                                return prefix.indexOf(item) === index
                            })
                            if (prefix.length == 1) {
                                default_prefix = prefix[0] + '-'
                            }
                        }
    

                        this.$set(translation, 'key', this.slugify(default_prefix + translation.translation['en']))
                    }
                })
            },
            removeTranslation(index) {
                if (confirm('¿Está seguro de eliminar esta traducción?')) {
                    if (this.translations[index].id) {
                        this.translations[index].deleted_at = new Date()
                    } else {
                        this.translations.splice(index, 1);
                    }
                }
            },
            restoreTranslation(index) {
                if (confirm('¿Está seguro de restaurar esta traducción?')) {
                    this.translations[index].deleted_at = null
                }
            },
            addTranslation() {
                this.translations.push({
                    key: '',
                    translation: {}
                });
            },
            saveTranslations() {
                this.componentState = 'saving'
                let formData = new FormData()
                formData.append('translations', JSON.stringify(this.translations))
                axios.post(window.apis.translation_manager + '/store', formData)
                    .then(response => {
                        this.componentState = 'loaded'
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            messageInConstruction() {
                alert('Esta función está en construcción')
            },
            keySlug(translation) {
                translation.key = this.slugify(translation.key)
            }
        }
  }
</script>
<style lang="scss" scoped>

</style>