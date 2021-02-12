<template>
    <div class="">

                    <router-link :to="{ name: 'cren' }"> <Button label="Añadir"/></router-link>



        <DataTable :value="data2"  :paginator="true" :rows="10" 
        class="p-datatable-gridlines"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]" >



        <template #empty>
           Sin resultados
       </template>
    <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field"></Column>
    <Column field="value" headerStyle="width: 3rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
        <template #body="slotProps">

            <router-link :to="{ name: 'cre', params: { file: slotProps.data.header }}"><i class="fa fa-cog"></i></router-link>


        </template>
    </Column>

</DataTable>

</div>
</template>

<script>
    export default {
        data(){
            return{
                languages: {},
        columns: [

            {field: 'value', header: 'File'}           
            
        ],
                data: [],
                data2: [],
                inputs: [],
                loaded: 0
            }
        },
        mounted() {
            console.log('Component mounted.') 
            this.$nextTick(() => {
                axios.get('/adm/crud-generator').then((response) => {
                    
                    if(response.data) {
                        this.data  = response.data
                    }

               for (var index = 0; index < this.data.length; index++) {
                    console.log(index)
                    this.data2.push({ value: this.data[index], header: this.data[index] });

                }


                });
            });

        }
    }
</script>
