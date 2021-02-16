<template>
    <div class="">

<ConfirmDialog></ConfirmDialog>


<Dialog :visible.sync="productDialog" :style="{width: '450px'}" header="Nuevo usuario del sistema" :modal="true" class="p-fluid">
<img :src="'demo/images/product/' + product.image" :alt="product.image" class="product-image" v-if="product.image" />
<div class="p-field">
    <label for="name">Nombre</label>
    <InputText id="name" v-model.trim="product.name" required="true" autofocus :class="{'p-invalid': submitted && !product.name}" />
    <small class="p-invalid" v-if="submitted && !product.name">Nombre oblitatorío.</small>
</div>


<div class="p-field">
    <label class="p-mb-3">Grupo</label>
    <div class="p-formgrid p-grid">
        <div class="p-field-radiobutton p-col-6">
            <RadioButton id="category1" name="category" value="gerencia" v-model="product.category" />
            <label for="category1">Gerencia</label>
        </div>
        <div class="p-field-radiobutton p-col-6">
            <RadioButton id="category2" name="category" value="jefes-de-taller" v-model="product.category" />
            <label for="category2">Jefe de Taller</label>
        </div>
        <div class="p-field-radiobutton p-col-6">
            <RadioButton id="category3" name="category" value="ingenieros" v-model="product.category" />
            <label for="category3">Ingeniero</label>
        </div>
        <div class="p-field-radiobutton p-col-6">
            <RadioButton id="category4" name="category" value="taller" v-model="product.category" />
            <label for="category4">Operario</label>
        </div>
    </div>
</div>
<div class="p-formgrid p-grid" v-if="product.category == 'taller'">
    <div class="p-field p-col">
<Dropdown v-model="product.sector" :options="sectores" optionValue="id" optionLabel="name" placeholder="Seleccione sector" />
</div>

</div>
<div class="p-formgrid p-grid">
    <div class="p-field p-col">
        <label for="price">Usuario</label>
        <InputNumber id="price" v-model="product.price" mode="currency" currency="USD" locale="en-US" />
    </div>
    <div class="p-field p-col">
        <label for="quantity">Contraseña</label>
        <InputNumber id="quantity" v-model="product.quantity" integeronly />
    </div>
</div>
<template #footer>
    <Button label="Cancelar" icon="pi pi-times" class="p-button-text"/>
    <Button label="Guardar" icon="pi pi-check" class="p-button-text"  />
</template>
</Dialog>



        <DataTable :value="data" dataKey="id" :paginator="true" :rows="10" :filters="filters"
        class="p-datatable-gridlines"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]" >


        <template #header>

            <div class="p-d-flex p-jc-between p-mx-auto">
                <div style=""> 
                    <h3> Usuarios </h3>


                </div>


                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="filters['global']" placeholder="Buscar..." />
                </span>
                <Button label="Nuevo" icon="pi pi-plus" class="p-button-success p-mr-2" @click="openNew" />
            </div>
        </template>


        <template #empty>
           Sin resultados
       </template>

       <Column field="name" header="Nombre"></Column>
       <Column field="grupito" header="Grupo">
        <template #body="slotProps">
        <span v-for="grup in slotProps.data.grupito">

            {{ grup.description  }}

        </span>
        </template>
       </Column>

        <Column> 
        <template #body="slotProps">
            <Button icon="pi pi-pencil" class="p-button-rounded p-button-success p-mr-2" @click="edit(slotProps.data.id)" />
            <Button icon="pi pi-trash" class="p-button-rounded p-button-warning" @click="del(slotProps.data.id)" />
        </template>
    </Column>

</DataTable>

</div>
</template>

<script>

import UserService from './../../service/UserService';


import ConfirmDialog from 'primevue/confirmdialog';

    export default {



        data() {
            return {
                              sectores: null,
            products: null,
            productDialog: false,
            deleteProductDialog: false,
            deleteProductsDialog: false,
            product: {},
            selectedProducts: null,
            filters: {},
            submitted: false,
                columns: [],
                data: [],
                inputs:  [],
                rels:  [],
                filters: {},
                tablename: 'users', 
                title: ''
            }
            
        },
        components:  { ConfirmDialog },
        watch:{ 
            '$route.params.table': function (table){

                this.load()

            },



        },
        created() {
        this.UserService = new UserService();
           this.SectorService = new SectorService();


        },
        mounted() {

          this.SectorService.getSectores().then(data => this.sectores = data);
            //this.tablename = this.$route.params.table
            //this.UserService.getTable(this.tablename).then(data => this.inputs = data.inputs);
           // this.UserService.getData(this.tablename).then(data => this.data = data);
           this.load()

    },
    methods:{
        openNew() {
            this.product = {};
            this.submitted = false;
            this.productDialog = true;
        },

        load(){
            this.data = [];
            this.inputs = [];
            this.columns = [];
            this.rels = [];
          this.SectorService.getSectores().then(data => this.sectores = data);
            this.UserService.getUsers().then(data => { 
                this.data = data
             });


        },
        edit(item) {


        },
        del(item) {


        },



    }
}
</script>
