<template>
	<div class="p-grid">


<div class="p-col-6">
<Card style="margin-bottom: 2em; margin-right: 1em; ">
    <template #title>
        Orden de Produccion:    {{ op2.code }}
    </template>
    <template #content>
        <h5> <strong>Cliente: </strong> {{ op2.client_name }}  </h5>
        <h5> <strong>F. de Ingreso: </strong> {{ op2.ingreso_fecha }}  </h5>
        <h5> <strong>F. Prometida: </strong> {{ op2.prometida_fecha }} - ( {{ op2.entrega_fecha }}) </h5>


    </template>
}
}
</Card>

</div>

<div class="p-col-6">
<Card style="margin-bottom: 2em; margin-right: 1em; ">
    <template #title>
        Detalle
    </template>
    <template #content>
        {{ op2.detail }}

    </template>
</Card>

<Card style="margin-bottom: 2em; margin-right: 1em; ">
    <template #title>
        Preguntas
    </template>
    <template #content>
        {{ op2.preguntas }}

    </template>
</Card>

</div>




<div class="p-col-12">
    <router-link  :to="{ name: 'coti', params: { id: this.$route.params.id }}" v-if="op2.status <= 2"><Button class="" label="Generar"> Crear orden de trabajo </Button></router-link>

    <a :href="'/cerrarp/' + this.$route.params.id" v-if="op2.status !== 2"><Button class="p-button-success" label="LISTO" /> </a>

</div>


        <div class="p-col-12">

            <otilist :id="this.$route.params.id" />

        </div>


        <div class="p-col-12">

            <otilist2 :id="this.$route.params.id" />

        </div>


	</div>
</template>
<script>

import TimerOti from './../TimeOti.vue';
import TimerOtiFlat from './../TimerOtiFlat.vue';
import OtiService from '../../service/OtiService';


export default {
    data() {
        return {
            op: null,
            products: null,
            layout: 'grid',
            sortKey: null,
            sortOrder: null,
            sortField: null,
            sortOptions: [
                {label: 'Ingreso', value: '!status'},
                {label: 'Tiempo', value: 'status'},
            ]
        }
    },
    components: { 
        'TimerOti':  TimerOti,
        'TimerOtiFlat':  TimerOtiFlat
    },
    computed: {
        op2: function() {
            return this.op;
        }
    },
    productService: null,
    created() {
        this.OtiService = new OtiService();
    },
    mounted() {
        this.OtiService.getOtisP(this.$route.params.id).then(data => this.products = data);
        this.OtiService.getOP(this.$route.params.id).then(data => this.op = data);



    },
    methods: {
        onSortChange(event){
           /* const value = event.value.value;
            const sortValue = event.value;

            if (value.indexOf('!') === 0) {
                this.sortOrder = -1;
                this.sortField = value.substring(1, value.length);
                this.sortKey = sortValue;
            }
            else {
                this.sortOrder = 1;
                this.sortField = value;
                this.sortKey = sortValue;
            }*/
        }
    }
}

</script>

<style type="text/css">
	
.card {
    background-color: #fff;
    padding: 1em;
    margin-bottom: 16px;
    border-radius: 3px;
}


</style>