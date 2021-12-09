<template>
	<button type="button" @click="clickBtn()">
        <slot></slot>
    </button>
</template>
<script>
    import Swal from 'sweetalert2';
    export default {
        props: {
            href: {
                type: String,
                required: true
            },
            confirmText: {
                type: String,
                default: 'Are you sure?'
            }
        },
		data() {
			return {};
		},
        created() {},
        mounted () {
			this.$nextTick(function () {})
        },
        watch: {},
        methods: {
            clickBtn() {
                console.log(this.href);
                Swal.fire({
                    title: this.confirmText,
                    text: '',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, seguro!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = this.href;
                    }
                })
            }
        }
    }
</script>
<style lang="scss" scoped>
</style>
