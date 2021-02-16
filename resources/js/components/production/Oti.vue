<template>
	<div class="p-grid">
<div class="p-col-12">


{{ oti }}
    <div class="p-d-flex p-jc-between">
    <div><h1>{{ oti.oti_name }}</h1></div>
<div>

<Button icon="pi pi-bell" class="p-button-lg p-button-rounded p-button-danger" label="Ayuda" />

</div>
</div>


</div>
          <TimerOtiFlat  :otiname="oti.oti_name" :status="oti.status" :from="oti.created_at" :oti="oti.id" :elapsed="oti.elapsed"  
          :obs="oti.motive" />



<div class="p-col-6">
<Card style="margin-bottom: 2em; margin-right: 1em; ">
    <template #title>
        Pieza
    </template>
    <template #content>
        <p> {{ oti.piece_name }} </p>

    </template>
</Card>
</div>

<div class="p-col-6">
<Card style="margin-bottom: 2em; margin-right: 1em; ">
    <template #title>
        Instrucciones
    </template>
    <template #content>
        <p> {{ oti.detail }} </p>

    </template>


</Card>
</div>
<div class="p-col-6"  v-if="oti.piece_name !== '-'">
<Card style="margin-bottom: 2em; margin-right: 1em; ">
    <template #title>
        Planos
    </template>
    <template #content>
        <p v-for="plano in oti.planos"> <Button label="Secondary" icon="pi pi-file" class="p-button-secondary" :label="plano.name + ' - Rev.: ' + plano.revision" @click="openPlane(plano.file)" /> </p>

    </template>


</Card>
</div>
<div class="p-col-6" >
<Card style="margin-bottom: 2em; margin-right: 1em; ">
    <template #title>
        Material
    </template>
    <template #content>
        <p> {{ oti.material_name }} </p>
    </template>
</Card>

<Card style="margin-bottom: 2em; margin-right: 1em; ">
    <template #title>
        Preguntas
    </template>
    <template #content>
        <p> {{ oti.preguntas }} </p>
    </template>
</Card>
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
            oti: null,
            layout: 'grid',
            sortKey: null,
            sortOrder: null,
            sortField: null,
            perms: this.$parent.authPermissions.map(perm => perm.id),
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
    productService: null,
    created() {
        this.OtiService = new OtiService();
    },
    mounted() {
        this.OtiService.getOti(this.$route.params.id).then(data => this.oti = data);
    },
    methods: {
        openPlane(file) {   
          window.open("/storage/"+file, "_blank");    
      },
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