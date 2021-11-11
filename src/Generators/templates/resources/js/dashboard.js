require('../../vendor/aporteweb/dashboard/src/resources/js/dashboard')

// Vue.component('producto-form', require('./components/admin/ProductoFormComponent.vue').default);


import Vuelidate from 'vuelidate'
window.Vue.use(Vuelidate)

import swal from 'sweetalert2';
window.Swal = swal;

const app = new window.Vue({
    el: '#app',
    data: {
        ver: '',
        iva: 0,
        markup: 0,
        actions: {
            'mode-edit': false,
            'price-view': false,
            'display-markup': false,
            'display-debug-values-pedidos': false,
        },
        targetFocus: null
    }
})

window.dashboardInit()
