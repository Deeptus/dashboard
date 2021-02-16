<template>
    <div class="">




        <DataTable :value="data" dataKey="id" :paginator="true" :rows="15" :filters="filters" :rowHover="true"
        class="p-datatable-gridlines"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[15,20,50]" >


        <template #header>
            <div class="table-header d-flex">
                <div style="font-size: 2rem; width: 100%;">
                {{ title }}
                </div>
                <div>
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="filters['global']" placeholder="Buscar..." />
                </span>
                </div>
            </div>
        </template>


        <template #empty>
           Sin resultados
       </template>



        <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field" sortable>

                <template #filter >
                    <div  v-if="col.type == 'text'" >
                        <input type="text" v-model="filters[col.field]" class="form-control" placeholder=""/>
                    </div>
                    <div  v-if="col.type == 'date'" >
                        <input type="date" v-model="filters[col.field]" class="form-control" />
                    </div>
                    <div  v-if="col.type == 'select' && col.options">
                        <Dropdown v-model="filters[col.field]" :options="col.options"  optionLabel="text" placeholder="Seleccionar" class="p-column-filter" optionValue="key"  
                        :showClear="true" >
                        </Dropdown>
                    </div>


                </template>

                <template #body="slotProps">
                    
                            <div  v-if="col.type == 'text'" >


                                {{ slotProps.data[col.field] }}
                            </div>

                            <div  v-if="col.type == 'select'  && col.options" >
                                {{ getTextOfOption(slotProps.data[col.field], col.options) }}
                            </div>

                            <div  v-if="col.type == 'date'" >
                                {{ formatDate(slotProps.data[col.field]) }}
                            </div>
                    
                            <div  v-if="col.type == 'file'" >

                                
                                <a :href="'/storage/'+slotProps.data[col.field]"> Descargar </a>
                            </div>

                            <div  v-else >

                            </div>


                </template>

        </Column>

        <Column>
            <template #body="slotProps">

                <a :href="'/adm/crud/'+tablename+'/'+slotProps.data.id + '/edit'" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                      <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                  </svg>
                  <span class="visually-hidden">editar</span>
              </a>

                <button type="button" class="btn btn-outline-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                  <span class="visually-hidden">borrar</span>
              </button>
          </template>

       </Column>

</DataTable>

</div>
</template>

<script>



    export default {



        data() {
            return {
                columns: [],
                data: [],                
                filters: {},

            }
            
        },
        props: ['table', 'inputs', 'tablename', 'title'],

        created() {
            this.data    = this.table
           // console.log(this.data)

        console.log(this.table)
        for (var index = 0; index < this.inputs.length; index++) {
            if(this.inputs[index]['visible'] == 1 && this.inputs[index]['visible'] )
                this.columns.push({ 
                 field: this.inputs[index]['columnname'],
                 header: this.inputs[index]['label']['es'],
                 type: this.inputs[index]['type'],
                 options: this.inputs[index]['options']  });
        }

        },
        mounted() {
           // this.productService.getProductsSmall().then(data => this.products = data);
          // console.log(this.title)
    },
    methods:{
        getTextOfOption(key, options){

            let found = options.find(element => element.key == key);

            return found.text

        },

        formatDate(date) {
            let month = date.getMonth() + 1;
            let day = date.getDate();

            if (month < 10) {
                month = '0' + month;
            }

            if (day < 10) {
                day = '0' + day;
            }

            return date.getFullYear() + '-' + month + '-' + day;
        },

        edit(item) {

            console.log('edit')

        },
        deletear(item) {

            console.log('deletear')


        },



    }
}
</script>
