<template>
    <div :class="getClass(input)" v-if="input.settable == 0">
        <InputText :value="value" :input="input" v-if="layout[input.type] == 'basic'"></InputText>
        <InputColor :value="value" :input="input" v-if="layout[input.type] == 'color'"></InputColor>
        <InputDate :value="value" :input="input" v-if="layout[input.type] == 'date'"></InputDate>
        <InputSelect :relations="relations" :value="value" :input="input" v-if="layout[input.type] == 'select'"></InputSelect>
        <SubForm :relations="relations" :value="value" :subForm="subForm" :input="input" v-if="layout[input.type] == 'subForm'"></SubForm>
        <CustomGallery :useFileManager="true" :label="input.label[lang()]" :model.sync="value" v-if="input.type == 'gallery'"></CustomGallery>
        <MapSelectLatLon :value="value" :input="input" v-if="input.type == 'map-select-lat-lng'"></MapSelectLatLon>
        <MultimediaFile :value="value" :input="input" v-if="input.type == 'multimedia_file'"></MultimediaFile>
        <wysiwyg :value="value" :input="input" v-if="input.type == 'wysiwyg'"></wysiwyg>
        <div v-if="displayDebug == 1">{{ value }} <button @click="reloadDebug">reload</button></div>
        <div v-if="input.type == 'card-header'" class="card-header">
            {{ input.columnname }}
        </div>
    </div>
</template>
<script>
    import InputText   from './InputText'
    import InputColor   from './InputColor'
    import InputDate   from './InputDate'
    import InputSelect from './InputSelect'
    import SubForm     from './SubForm'
    import MapSelectLatLon from './MapSelectLatLon'
    import CustomGallery   from '../CustomGalleryComponent'
    import MultimediaFile  from './MultimediaFile'
    import Wysiwyg  from './Wysiwyg'

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
            InputColor,
            InputDate,
            InputSelect,
            SubForm,
            MapSelectLatLon,
            MultimediaFile,
            CustomGallery,
            Wysiwyg
        },
        data(){
            return{
                layout: {
                    "text": 'basic',
                    "color": 'color',
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
