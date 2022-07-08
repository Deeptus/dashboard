<template>
    <div class="typeahead-container">
        <input
            type="text"
            v-model="modelData.company"
            class="form-control typeahead-filter"
            id="company"
            name="company"
            value=""
            autocomplete="off"
            autocorrect="off"
            autocapitalize="none"
            spellcheck="false"
            @focus="displayList = true"
            @blur="hideList()"
        >
        <div
            class="typeahead-results"
        >
            <div class="list-group" v-show="displayList">
                <a
                    v-for="item in filteredList"
                    class="text-gray-100 list-group-item list-group-item-action typeahead-item"
                    autocomplete="nope"
                    @click="Object.assign(modelData, item)"
                >
                    {{ item.company }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['model','data'],
        model: {
            prop: 'model',
        },
        data(){
            return{
                modelData: this.model,
                displayList: false
            }
        },
        mounted() {

        },
        methods:{
            noHideList() {
                this.displayList=true
            },
            hideList() {
                var self = this;
                setTimeout(function(){ self.displayList=false }, 150);
            }
        },
        computed: {
            filteredList() {
                return this.data.filter(data => {
                    //console.log([data.company, this.modelData.company])
                    return data.company.toLowerCase().includes(this.modelData.company.toLowerCase())
                })
            }
        }
  }
</script>
<style type="text/css" scoped="">
    .typeahead-container {
        position: relative;
    }
    .typeahead-results {
        position: absolute;
        background-color: rgba(0,0,0,0.1);
        left: 0;
        right: 0;
        z-index: 9999999;
    }
    .typeahead-item {
        cursor: pointer;
    }
    .typeahead-item:hover {
        font-weight: bold;
    }
</style>
