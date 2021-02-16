<template>
<div>

<Toolbar class="p-mb-4">
    <template #left>

    </template>

    <template #right>

<div class="col-auto">

    <router-link to="newprod" class="btn app-btn-primary"><svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="bi bi-clipboard-plus"><path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"></path> <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3zM8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"></path></svg>
    Añadir
    </router-link>

</div>

    </template>
</Toolbar>



<DataTable :value="customers" :paginator="true" class="p-datatable-sm" :rows="15"
	:rowHover="true"
	:rowClass="rowClass"
    dataKey="id" :filters="filters" :loading="loading"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5, 10,15,25,50]"
    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries">
    <template #header>
        <div class="table-header d-flex">
            <div style="font-size: 1.8rem; width: 100%;">Producción</div>
            <span class="p-input-icon-left">
                <i class="pi pi-search" />
                <InputText v-model="filters['global']" placeholder="Buscador global" />
            </span>
        </div>
    </template>
    <template #empty>
        No se encontraron ordenes de producción.
    </template>
    <template #loading>
        Cargando datos, espere porfavor.
    </template>
    <Column  headerStyle="width: 6rem; text-align: center" header="OP" field="code" filterField="code" filterMatchMode="contains" :sortable="true">
        <template #body="slotProps">
            
            <span >{{  slotProps.data.code }}</span>
        </template>
        <template #filter>
            <InputText type="text" v-model="filters['code']" class="p-column-filter" placeholder="Buscar por código"/>
        </template>
    </Column>
    <Column  headerStyle="width: 15%;" field="client_name" header="Cliente" :sortable="true">
        <template #body="slotProps">
            
            {{slotProps.data.client_name}}
        </template>
        <template #filter>
            <InputText type="text" v-model="filters['client_name']" class="p-column-filter" placeholder="Buscar por cliente"/>
        </template>
    </Column>

    </Column>
    <Column headerStyle="width: 25%; text-align: center" field="detail" header="Detalle" :sortable="true">
        <template #body="slotProps">
            <span v-if="slotProps.data.oc "> O/C:
            {{ slotProps.data.oc }}</span>
            {{slotProps.data.detail}} *
        </template>
        <template #filter>
            <InputText type="text" v-model="filters['detail']" class="p-column-filter" filterMatchMode="contains"  placeholder="Buscar por detalle"/>
        </template>
    </Column>
    <Column  headerStyle="width: 8rem; text-align: center" field="ingreso_fecha" header="Ingreso" filterMatchMode="custom" :filterFunction="filterDate" :sortable="true">
        <template #body="slotProps">

            <span>{{ slotProps.data.ingreso_fecha }}</span>
        </template>
        <template #filter>
            <Calendar v-model="filters['ingreso_fecha']" dateFormat="dd-mm-yy" class="p-column-filter" placeholder="Fecha de ingreso" :showButtonBar="true"/>
        </template>
    </Column>
    <Column  headerStyle="width: 8rem; text-align: center" field="prometida_fecha" header="Entrega" filterMatchMode="custom" :filterFunction="filterDate" :sortable="true">
        <template #body="slotProps">

            <span>{{ slotProps.data.prometida_fecha }}</span>
        </template>
        <template #filter>
            <Calendar v-model="filters['prometida_fecha']" dateFormat="dd-mm-yy" class="p-column-filter" placeholder="Fecha prometida" :showButtonBar="true"/>
        </template>
    </Column>
    <Column  field="neto_iva" header="$" :sortable="true" v-if="this.perms.includes(9)" >
        <template #body="slotProps" >
            
<div class="p-text-nowrap" v-if="slotProps.data.moneda  == '1'"><strong>
AR$</strong>  {{ slotProps.data.neto_iva | toMoney }}
</div>
<div class="p-text-nowrap" v-else-if="slotProps.data.moneda  == '2'"><strong>
U$D</strong>  {{ slotProps.data.neto_iva  | toMoney }}
</div>
<div class="p-text-nowrap" v-else-if="slotProps.data.moneda  == '3'"><strong>
€UR</strong>  {{ slotProps.data.neto_iva  | toMoney }} 
</div>
<div class="p-text-nowrap" v-else><strong>
$  </strong>{{ slotProps.data.neto_iva   | toMoney }}
</div>

           
        </template>

    </Column>
    <Column field="status_parsed" header="Estado" filterMatchMode="equals" :sortable="true">
        <template #body="slotProps">            
            <span :class="'order-badge status-' + slotProps.data.status">{{slotProps.data.status_parsed}}</span>
        </template>
        <template #filter>
            <Dropdown v-model="filters['status_parsed']" :options="statuses" placeholder="Seleccione" class="p-column-filter" :showClear="true">
                <template #option="slotProps">
                    <span :class="'order-badge status-' + slotProps.option">{{slotProps.option}}</span>
                </template>
            </Dropdown>
        </template>
    </Column>
    <Column headerStyle="width: 4rem;" field="consumed" header="Hs." :sortable="true">
        <template #body="slotProps">
            
            {{ slotProps.data.consumed }}
        </template>

    </Column>

    <!----- <Column field="activity" header="Progreso" filterMatchMode="gte" :sortable="true">
        <template #body="slotProps">
            
            <ProgressBar :value="slotProps.data.activity" :showValue="true" />
        </template>
        <template #filter>
            <InputText type="text" v-model="filters['activity']" class="p-column-filter" placeholder="Minimo %"/>
        </template>
    </Column> ------>
    <Column field="id" headerStyle="width: 3rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
        <template #body="slotProps">
            <router-link :to="{ name: 'pdetail', params: { id: slotProps.data.id }}"><i class="fa fa-cog"></i></router-link>
        </template>
    </Column>
</DataTable>
</div>
</template>
<script>
	
import ProductionService from './../../service/ProductionService';

export default {
    data() {
        return {
            customers: null,
            perms: this.$parent.authPermissions.map(perm => perm.id),
            filters: {},
            loading: true,
            representatives: [
                {name: "Amy Elsner", image: 'amyelsner.png'},
                {name: "Anna Fali", image: 'annafali.png'},
                {name: "Asiya Javayant", image: 'asiyajavayant.png'},
                {name: "Bernardo Dominic", image: 'bernardodominic.png'},
                {name: "Elwin Sharvill", image: 'elwinsharvill.png'},
                {name: "Ioni Bowcher", image: 'ionibowcher.png'},
                {name: "Ivan Magalhaes",image: 'ivanmagalhaes.png'},
                {name: "Onyama Limba", image: 'onyamalimba.png'},
                {name: "Stephen Shaw", image: 'stephenshaw.png'},
                {name: "XuXue Feng", image: 'xuxuefeng.png'}
            ],
            statuses: [
                'Recibido O/C', 'En proceso', 'Listo', 'Recepcionado',
            ]
        }
    },
    created() {
        this.customerService = new ProductionService();
    },
    mounted() {
        this.customerService.getProductionLarge().then(data => this.customers = data);
        this.loading = false;
    },
    methods: {
        rowClass(data) {
        	//console.log(data)
            return data.demorado === true ? 'row-demorado': null;
        },
        filterDate(value, filter) {
        	//console.log(this.formatDate(filter))
            if (filter === undefined || filter === null || (typeof filter === 'string' && filter.trim() === '')) {
                return true;
            }

            if (value === undefined || value === null) {
                return false;
            }

            return value === this.formatDate(filter);
        },
        formatDate(date) {
            let month = date.getMonth() + 1;
            let day   = date.getDate();
            let year  = date.getFullYear()
    		
    		year = year.toString().substr(-2);

            if (month < 10) {
                month = '0' + month;
            }

            if (day < 10) {
                day = '0' + day;
            }

            return day + '-' + month + '-' + year
        }
    }
}



</script>

<style scoped>
	
.p-column-filter {
	width: 100%;
}

.order-badge {
 border-radius:2px;
 padding:.25em .5rem;
 text-transform:uppercase;
 font-weight:700;
 font-size:12px;
 letter-spacing:.3px
}

.status-0 {
 background:#eccfff;
 color:#694382
}


.status-2 {
 background:#c8e6c9;
 color:#256029
}

.status-danger {
 background:#ffcdd2;
 color:#c63737
}

.status-1 {
 background:#feedaf;
 color:#8a5340
}



/deep/ .p-paginator {
    .p-paginator-current {
        margin-left: auto;
    }
}

/deep/ .p-progressbar {
    height: .5rem;
    background-color: #D8DADC;

    .p-progressbar-value {
        background-color: #00ACAD;
    }
}

.table-header {
    display: flex;
    justify-content: space-between;
}

/deep/ .p-datepicker {
    min-width: 25rem;

    td {
        font-weight: 400;
    }
}
/deep/ .row-demorado {
    background-color: rgb(255, 205, 210) !important;

}

/deep/ .p-datatable.p-datatable-customers {
    .p-datatable-header {
        padding: 1rem;
        text-align: left;
        font-size: 1.5rem;
    }

    .p-paginator {
        padding: 1rem;
    }

    .p-datatable-thead > tr > th {
        text-align: left;
    }

    .p-datatable-tbody > tr > td {
        cursor: auto;
    }

    .p-dropdown-label:not(.p-placeholder) {
        text-transform: uppercase;
    }
}

/* Responsive */
.p-datatable-customers .p-datatable-tbody > tr > td .p-column-title {
    display: none;
}

@media screen and (max-width: 64em) {
    /deep/ .p-datatable {
        &.p-datatable-customers {
            .p-datatable-thead > tr > th,
            .p-datatable-tfoot > tr > td {
                display: none !important;
            }

            .p-datatable-tbody > tr > td {
                text-align: left;
                display: block;
                border: 0 none !important;
                width: 100% !important;
                float: left;
                clear: left;
                border: 0 none;

                .p-column-title {
                    padding: .4rem;
                    min-width: 30%;
                    display: inline-block;
                    margin: -.4rem 1rem -.4rem -.4rem;
                    font-weight: bold;
                }
            }
        }
    }
}
</style>