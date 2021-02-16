<template>
	<div class="p-grid">
		123
		<div class="p-col-12 p-md-6">
			<div class="card p-fluid">
				<h5>Orden de Producción</h5>
				<div class="p-field">
					<label for="name1">Código</label>
					<InputText id="name1" type="text" :value="data.code"/>
				</div>
				<div class="p-field">
					<label for="email1">Cliente</label>
					<InputText id="email1" type="text" :value="data.client_name"/>
				</div>
				<div class="p-field">
					<label for="age1">Detalle</label>
					<InputText id="age1" type="text" :value="data.detail"/>
				</div>
			</div>

			<div class="card p-fluid">
				<h5>Fechas</h5>
				<div class="p-formgrid p-grid">
					<div class="p-field p-col">
						<label for="name2">Ingreso</label>
						<InputText id="name2" type="text" :value="data.ingreso_fecha"/>
					</div>
					<div class="p-field p-col">
						<label for="email2">Prometida</label>
						<InputText id="email2" type="text" :value="data.prometida_fecha"/>
					</div>
				</div>
			</div>
		</div>

		<div class="p-col-12 p-md-6">
			<div class="card p-fluid">
				<h5>Valor</h5>
				<div class="p-field p-grid">
					<label for="name3" class="p-col-12 p-mb-2 p-md-2 p-mb-md-0">Moneda</label>
					<div class="p-col-12 p-md-10">
						<InputText id="name3" type="text" :value="data.moneda"/>
					</div>
				</div>
				<div class="p-field p-grid">
					<label for="email3" class="p-col-12 p-mb-2 p-md-2 p-mb-md-0">Neto</label>
					<div class="p-col-12 p-md-10">
						<InputText id="email3" type="text" :value="data.neto_iva"/>
					</div>
				</div>
			</div>

			<div class="card p-fluid">
				<h5>General</h5>
				<div class="p-field p-grid">
					<label for="name3" class="p-col-12 p-mb-2 p-md-2 p-mb-md-0">O.C.</label>
					<div class="p-col-12 p-md-10">
						<InputText id="name3" type="text" :value="data.oc"/>
					</div>
				</div>
				<div class="p-field p-grid">
					<label for="email3" class="p-col-12 p-mb-2 p-md-2 p-mb-md-0">Cantidad</label>
					<div class="p-col-12 p-md-10">
						<InputText id="email3" type="text" :value="data.original_quantity"/>
					</div>
				</div>
				<div class="p-field p-grid">
					<label for="email3" class="p-col-12 p-mb-2 p-md-2 p-mb-md-0">Estado</label>
					<div class="p-col-12 p-md-10">
						<InputText id="email3" type="text" :value="data.status"/>
					</div>
				</div>
				<div class="p-field p-grid">
					<label for="email3" class="p-col-12 p-mb-2 p-md-2 p-mb-md-0">Preguntas</label>
					<div class="p-col-12 p-md-10">
						<InputText id="email3" type="text" :value="data.preguntas"/>
					</div>
				</div>
			</div>

		</div>

		<div class="p-col-12">
			<div class="card">



				<otilist :id="data.id" />

			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				dropdownItems: [
					{name: 'Option 1', code: 'Option 1'},
					{name: 'Option 2', code: 'Option 2'},
					{name: 'Option 3', code: 'Option 3'}
				],
				dropdownItem: null,
			}
		},
		props: ['data'],
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