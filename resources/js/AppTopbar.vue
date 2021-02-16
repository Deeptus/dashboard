<template>
	<div class="layout-topbar">
		<button class="p-link layout-menu-button" @click="onMenuToggle">
			<span class="pi pi-bars"></span>
		</button>
		<div class="layout-topbar-icons">
					<button class="p-link "  @click="$router.go(-1)">
			<span class="pi pi-chevron-left"> </span> VOLVER
		</button>

		</div>
	</div>
</template>

<script>
export default {
    methods: {
        onMenuToggle(event) {
            this.$emit('menu-toggle', event);
        }
    }
}
</script>


<style type="text/css">

</style>