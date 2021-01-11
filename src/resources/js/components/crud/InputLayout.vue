<template>
    <div :class="getClass(input)">
        <InputText :value="value" :input="input" v-if="layout[input.type] == 'basic'"></InputText>
        <InputDate :value="value" :input="input" v-if="layout[input.type] == 'date'"></InputDate>
        <InputSelect :relations="relations" :value="value" :input="input" v-if="layout[input.type] == 'select'"></InputSelect>
        <SubForm :relations="{}" :value="value" :subForm="subForm" :input="input" v-if="layout[input.type] == 'subForm'"></SubForm>
        <CustomGallery :label="input.label[lang()]" :model.sync="value" v-if="input.type == 'gallery'"></CustomGallery>
        <MapSelectLatLon :value="value" :input="input" v-if="input.type == 'map-select-lat-lng'"></MapSelectLatLon>
        <MultimediaFile :value="value" :input="input" v-if="input.type == 'multimedia_file'"></MultimediaFile>
        <div v-if="displayDebug == 1">{{ value }} <button @click="reloadDebug">reload</button></div>
        <div v-if="input.type == 'card-header'" class="card-header">
            {{ input.columnname }}
        </div>
    </div>
</template>
<script>
    import InputText   from './InputText'
    import InputDate   from './InputDate'
    import InputSelect from './InputSelect'
    import SubForm     from './SubForm'
    import MapSelectLatLon from './MapSelectLatLon'
    import CustomGallery   from '../CustomGalleryComponent'
    import MultimediaFile  from './MultimediaFile'

    export default {
        name:"InputLayout",
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
                type: Object,
                default: {}
            }
        },
        components: {
            InputText,
            InputDate,
            InputSelect,
            SubForm,
            MapSelectLatLon,
            MultimediaFile,
            CustomGallery
        },
        data(){
            return{
                layout: {
                    "text": 'basic',
                    "textarea": 'basic',
                    "email": 'basic',
                    "url": 'basic',
                    "tel": 'basic',
                    "number": 'basic',
                    "money": 'basic',
                    "password": 'basic',
                    "true_or_false": 'select',
                    "date": 'date',
                    "time": 'date',
                    "datetime": 'date',
                    "week": 'date',
                    "select": 'select',
                    "radio": 'select',
                    "checkbox": 'select',
                    "select2": 'select',
                    "select2multiple": 'select',
                    "subForm": 'subForm'
                },
                displayDebug: 0
            }
        },
        created() {},
        mounted () {},
        watch: {},
        methods: {
            reloadDebug() {
                this.displayDebug = 0
                setTimeout(() => {
                    this.displayDebug = 1
                }, 2000)
            },
            getClass(input) {
                let classs = {}
                if (input.type == 'card-header') {
                    classs['col-md-12'] = true
                }
                if (input.gridcols) {
                    classs['col-md-' + input.gridcols] = true
                }
                return classs
            },
            lang() {
                return document.documentElement.lang
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>
.card-header {
    margin-right: -16px;
    margin-left: -16px;
    border-top: 1px solid rgba(0, 0, 0, 0.125);
    margin-bottom: 16px;
}
</style>
