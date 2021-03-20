<template>
    <div class="">

<ConfirmDialog></ConfirmDialog>



        <DataTable :value="data" dataKey="id" :paginator="true" :rows="10" :filters="filters"
        class="p-datatable-gridlines"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]" >


        <template #header>

            <div class="p-d-flex p-jc-between p-mx-auto">
                <div style=""> 
                    <h3>{{ title }}</h3>


                </div>


                    <InputText v-model="filters['global']" placeholder="Buscar..." />


                                <span class="">
                                    <router-link :to="{ name: 'crudcreate', params: { table:  $route.params.table }}"> 
                        <Button icon="pi pi-plus-circle" label="Añadir" class="p-button-primary p-button p-component" /></router-link>
                    </span>
            </div>
        </template>


        <template #empty>
           Sin resultados
       </template>


        <Column bodyClass=""  v-for="col of columns" :field="col.field" :header="col.header" :key="col.field" sortable>

                <template #filter>


                    <div  v-if="col.type == 'text'" >
                           <InputText type="text" v-model="filters[col.field]" class="p-column-filter" :placeholder="'Buscar por '+ col.header"/>
                    </div>


                    <div  v-if="col.type == 'date'" >
                            <Calendar v-model="filters[col.field]" dateFormat="dd-mm-yy" class="p-column-filter" placeholder="Fecha" :showButtonBar="true"/>
                    </div>

                    <div  v-if="col.type == 'select' && col.options">                     
                    <select v-model="filters[col.field]" style="width:100%;">
                        <option></option>
                        <option  v-for="opt of col.options" :value="opt.key" > {{opt.text}} </option>
                    </select>


                    </div>

                </template>



                <template  #body="slotProps" v-if="col.type == 'textarea'">
                    <div class="truncate" style="display: block ruby;text-overflow: ellipsis;overflow: hidden;">
                        <span class="" v-html="slotProps.data[col.field]" />
                    </div>
                </template>
                <template #body="slotProps" v-else-if="col.type == 'file'">


                        <!---<img :src="slotProps.data.file.replace('public/','storage/')"  class="product-image"  />
                       <!--- <Button label="Ver" icon="pi pi-file" class="p-button-secondary"  @click="openPlane(slotProps.data.file)" /> --->

                </template>
                <template #body="slotProps" v-else-if="col.type == 'boolean'">

                  
                        <InputSwitch :value="Boolean(Number(slotProps.data[col.field]))"  :disabled="true"/>

           <!---              <span v-if="slotProps.data[col.field] === 1">
                            <i class="pi pi-check"></i>
                        </span>
                        <span v-else> 
                            <i class="pi pi-times"></i> 
                        </span>
--->

                </template>
                <template #body="slotProps" v-else-if="col.type == 'checkbox'">

                      <Chip class="p-ml-1 p-mb-1"
                      :label="getKeyByValue(col.options,item)" v-for="item of splitMe(slotProps.data[col.field])" :key="item" />


                </template>
                <template #body="slotProps" v-else-if="col.type == 'radio'">

                        {{ getKeyByValue(col.options,slotProps.data[col.field]) }}

                </template>
                <template #body="slotProps" v-else-if="col.type == 'select'">
                    
                    <span v-if="col.tabledata && col.valueoriginselector == 'table' "> 
                        {{ rels[col.tabledata][slotProps.data[col.field]] }}
                    </span>
                    <span v-else-if="col.valueoriginselector == 'values' "> 
                        
                        {{ getKeyByValue(col.options,slotProps.data[col.field]) }}
                    </span>
                  <!---    {{ col.field }}
                        {{ col.options[slotProps.data[col.field] - 1].text }}
                    {{ this.rels[col.field][slotProps.data[col.field]] }}
                   <span>{{ this.rels[col.field] }}</span>
                    {{ slotProps.data[col.field + '_name']  }} --->
                </template>
                
        </Column>

        <Column v-if="columns.length >= 1">
        <template #body="slotProps">
            <Button icon="pi pi-pencil" class="p-button-rounded p-button-success p-mr-2" @click="edit(slotProps.data.id)" />
            <Button icon="pi pi-trash" class="p-button-rounded p-button-warning" @click="del(slotProps.data.id)" />
        </template>
    </Column>

</DataTable>

</div>
</template>

<script>

import CrudService from './../../service/CrudService';

import ConfirmDialog from 'primevue/confirmdialog';
import axios from 'axios'
    export default {



        data() {
            return {
                columns: [],
                data: [],
                inputs:  [],
                rels:  [],
                filters: {},
                tablename: this.$route.params.table,
                title: ''
            }
            
        },
        components:  { ConfirmDialog },
        watch:{ 
            '$route.params.table': function (table){

                this.load()

            },


            inputs(val) {
               for (var index = 0; index < this.inputs.length; index++) {
                    //console.log(index)
                    if(this.inputs[index]['visible'] == 1 || this.inputs[index]['visible'] == "1" ){
                        this.columns.push({ 

                            field: this.inputs[index]['columnname'],
                            header: this.inputs[index]['label']['es'],
                            type: this.inputs[index]['type'],
                            options: this.inputs[index]['options'],
                            tabledata: this.inputs[index]['tabledata'], 
                            valueoriginselector: this.inputs[index]['valueoriginselector']

                            });
 
                    }
                    
                }


            }

        },
        created() {
        this.CrudService = new CrudService();

        //console.log(this.data)

        },
        mounted() {


            //this.tablename = this.$route.params.table
            //this.CrudService.getTable(this.tablename).then(data => this.inputs = data.inputs);
           // this.CrudService.getData(this.tablename).then(data => this.data = data);
           this.load()

    },
    methods:{
        splitMe(string){
            if(string){
                return string.split(',')
            }else{
                return [];
            }
        },
        checkSplit(value){
            if(value){
                console.log(value)
                return true
            }
            

        },
        openPlane(file) {   
          window.open("/storage/"+file.replace('public/','storage/'), "_blank");    
        },
        getKeyByValue(object, value) { 
            //console.log(object, value)
            if(!value || value == null || value == '' || value == ""){
                 return ''
            
            }else{

            let text = object.filter(function (op) { return op.key == value });
            return text[0].text
            }
            

        },
        load(){
            this.data = [];
            this.inputs = [];
            this.columns = [];
            this.rels = [];


            this.tablename = this.$route.params.table
            this.CrudService.getTable(this.tablename).then(data => { 
                this.title = data.table.name.es
                this.inputs = data.inputs
                this.rels   = data.relations
             });

           // console.log(this.rels)
            this.CrudService.getTable(this.tablename).then(data => this.data = data.data);

        },
        edit(item) {

            console.log('edit')
            this.$router.push({ name: 'ced', params: { id: item }});
        },
        del(item) {

            this.$confirm.require({
                message: 'Seguro quieres eliminar esto?',
                header: 'Eliminar',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    //callback to execute when user confirms the action
                axios.get('/adm/crud/' + this.tablename + '/' + item + '/delete').then((response) => {
                    this.loaded = 3
                    setTimeout(() => {
                        //this.loaded = 1
                        this.load()
                    }, 1000);
                }).catch((error) => {

                    console.log(error)

                });

                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
            });


        },



    }
}
</script>
<style>
    .truncate span, p{
    display: block ruby;
  width: 100%;
  height: 120px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.product-image {
    width: 100px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23)
}
</style>