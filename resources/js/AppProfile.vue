<template>
	<div class="layout-profile">
		<div>

		</div>
		<button class="p-link layout-profile-link" @click="onClick">
			<span class="username"> {{ this.$parent.authUser.name }}</span>
			<i class="pi pi-fw pi-cog"></i>
		</button>
        <transition name="layout-submenu-wrapper">
            <ul v-show="expanded">


                <li><router-link :to="{ name: 'webconfig' }" style="color: white; font-weight: bolder;" class="p-link text-white" ><button class="p-link"><i class="pi pi-cog"></i><span>Sitio Web</span></button></router-link></li>

                <li><router-link :to="{ name: 'crudgenerator' }" style="color: white; font-weight: bolder;" class="p-link text-white" ><button class="p-link"><i class="pi pi-cog"></i><span>Desarrollador</span></button></router-link></li>


                <li><a href="/adm/logout" style="color: white; font-weight: bolder;" class="p-link text-white" ><button class="p-link"><i class="pi pi-fw pi-power-off"></i><span>Salir</span></button></a></li>
            </ul>
        </transition>
		
	</div>
</template>

<script>
	export default {
		data() {
			return {
				expanded: false
			}
		},
		methods: {
			onClick(event){
				this.expanded = !this.expanded;
				event.preventDefault();
			}
		}
	}
</script>

<style scoped>

</style>