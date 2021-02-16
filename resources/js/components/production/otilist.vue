<template>
<div>



<DataTable :value="customers" :paginator="true" class="p-datatable-sm" :rows="10"
	:rowHover="true"
	:rowClass="rowClass"
    dataKey="id" :filters="filters" :loading="loading"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5, 10,25,50]"
    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries">
    <template #header>
        <div class="table-header d-flex">
            <div style="font-size: 1.8rem; width: 100%;">Ordenes de trabajo</div>
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
    <Column  headerStyle="width: 8rem; text-align: center" header="N°" field="oti_name" filterField="oti_name" filterMatchMode="contains" :sortable="true">
        <template #body="slotProps">
            
            <span >{{  slotProps.data.oti_name }}</span>
        </template>
        <template #filter>
            <InputText type="text" v-model="filters['oti_name']" class="p-column-filter" placeholder="Buscar por código"/>
        </template>
    </Column>
    <Column  headerStyle="width: 15%;" field="piece_name" header="Pieza" :sortable="true">
        <template #body="slotProps">
            
            {{slotProps.data.piece_name}}
        </template>
        <template #filter>
            <InputText type="text" v-model="filters['piece_name']" class="p-column-filter" placeholder="Buscar por pieza"/>
        </template>
    </Column>

    <Column headerStyle="width: 25%; text-align: center" field="detail" header="Detalle" :sortable="true">
        <template #body="slotProps">
            
            {{slotProps.data.detail}}
        </template>
        <template #filter>
            <InputText type="text" v-model="filters['detail']" class="p-column-filter" placeholder="Buscar por detalle"/>
        </template>
    </Column>
    <Column  headerStyle="width: 8rem; text-align: center" field="inner_date" header="Ingreso" filterMatchMode="custom" :filterFunction="filterDate" :sortable="true">
        <template #body="slotProps">

            <span>{{ slotProps.data.inner_date_parsed }}</span>
        </template>
        <template #filter>
            <Calendar v-model="filters['inner_date']" dateFormat="dd-mm-yy" class="p-column-filter" placeholder="Fecha de ingreso" :showButtonBar="true"/>
        </template>
    </Column>


    <Column field="last_status" header="Estado" filterMatchMode="equals" :sortable="true">
        <template #body="slotProps">            
            <span :class="'order-badge status-' + slotProps.data.last_status">

            
<span v-if="slotProps.data.last_status  == 0">
    Sin iniciar
</span>
<span v-else-if="slotProps.data.last_status  == 1">
    En proceso
</span>
<span v-else-if="slotProps.data.last_status  == 2">
    Pausada - {{ slotProps.data.motive }}
</span>
<span v-else-if="slotProps.data.last_status  == 3">

</span>
<span v-else-if="slotProps.data.last_status  == 4">
    Finalizada
</span>
<span v-else>
    ?
</span>



            </span>
        </template>
        <template #filter>
            <Dropdown v-model="filters['status_parsed']" :options="statuses" placeholder="Seleccione" class="p-column-filter" :showClear="true">
                <template #option="slotProps">
                    <span :class="'order-badge status-' + slotProps.option">{{slotProps.option}}</span>
                </template>
            </Dropdown>
        </template>
    </Column>
        <Column field="current_operator" header="Operador" :sortable="true">
        <template #body="slotProps">
            
            {{slotProps.data.current_operator}}
        </template>
        <template #filter>
            <InputText type="text" v-model="filters['current_operator']" class="p-column-filter" placeholder="Buscar por operador"/>
        </template>
    </Column>
    
    <Column headerStyle="width: 8rem;" field="elapsed" header="Tiempo" :sortable="true">
        <template #body="slotProps">
            
            {{ secondsToDhms(slotProps.data.elapsed) }}
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
            <router-link  :to="{ name: 'oti', params: { id:  slotProps.data.id  }}" ><i class="fa fa-cog"></i> </router-link>
        </template>
    </Column>
</DataTable>
</div>
</template>
<script>
	
import OtiService from './../../service/OtiService';

export default {
    data() {
        return {
            customers: null,
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
                'Sin iniciar', 'En proceso', 'Pausada', 'Finalizada',
            ]
        }
    },
    props: ['id'],
    created() {
        this.customerService = new OtiService();
    },
    mounted() {
        this.customerService.getOtisP(this.id).then(data => this.customers = data);
        this.loading = false;
    },
    methods: {
 secondsToDhms(seconds) {
seconds = Number(seconds);
var d = Math.floor(seconds / (3600*24));
var h = Math.floor(seconds % (3600*24) / 3600);
var m = Math.floor(seconds % 3600 / 60);
var s = Math.floor(seconds % 60);

var dDisplay = d > 0 ? d + (d == 1 ? " día, " : " dias, ") : "";
var hDisplay = h > 0 ? h + (h == 1 ? " hora, " : " horas, ") : "";
var mDisplay = m > 0 ? m + (m == 1 ? " minuto, " : " minutos, ") : "";
var sDisplay = s > 0 ? s + (s == 1 ? " segundo" : " segundos") : "";
return dDisplay + hDisplay + mDisplay + sDisplay;
},
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


.status-1 {
 background:#c8e6c9;
 color:#256029
}

.status-danger {
 background:#ffcdd2;
 color:#c63737
}

.status-2 {
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