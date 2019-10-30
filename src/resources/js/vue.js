window.Vue = require('vue');

Vue.component('dynamic-content-form', require('./components/dynamic-content/DynamicContentFormComponent.vue').default);
require('../../../../../../resources/js/custom-dashboard');
Vue.filter('toCurrency', function (numero) {
    let decimales = 2
    let separadorDecimal = ','
    let separadorMiles = '.'
    let partes, array;

    if ( !isFinite(numero) || isNaN(numero = parseFloat(numero)) ) {
        return "";
    }
    if (typeof separadorDecimal==="undefined") {
        separadorDecimal = ",";
    }
    if (typeof separadorMiles==="undefined") {
        separadorMiles = "";
    }

    // Redondeamos
    if ( !isNaN(parseInt(decimales)) ) {
        if (decimales >= 0) {
            numero = numero.toFixed(decimales);
        } else {
            numero = (
                Math.round(numero / Math.pow(10, Math.abs(decimales))) * Math.pow(10, Math.abs(decimales))
            ).toFixed();
        }
    } else {
        numero = numero.toString();
    }

    // Damos formato
    partes = numero.split(".", 2);
    array = partes[0].split("");
    for (var i=array.length-3; i>0 && array[i-1]!=="-"; i-=3) {
        array.splice(i, 0, separadorMiles);
    }
    numero = array.join("");

    if (partes.length>1) {
        numero += separadorDecimal + partes[1];
    }

    return numero;
});
// import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.mixin({
  methods: {
    calcIva(val) {
        if (this.$root.actions['display-price-iva']) {
            return (val * ((this.$root.iva / 100) + 1))
        }
        return val
    },
    calcMarkup(val) {
        if (this.$root.actions['display-price-markup']) {
            return (val * ((this.$root.markup / 100) + 1))
        }
        return val
    },
    calcIvaMarkup (val) {
        return this.calcIva(this.calcMarkup(val))
    },
    displayPrice() {
        return this.$root.actions['price-view']
    },
    priceTbjEsp() {
        return this.$root.actions['price-tbj-esp']
    },
    formDisabled() {
        if (this.$root.actions['mode-edit']) {
            //return { pointerEvents: 'none' }
            return {}
        } else {
            return {}
        }
    },
    formEnabled(section) {
        return { pointerEvents: 'auto' }
    }
  }
})

// Vue.use( CKEditor );
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);

const app = new Vue({
    el: '#app',
    data: {
        markup: 0,
        actions: {
            'mode-edit': false,
            'price-view': false,
            'display-markup': false
        },
        targetFocus: null
    }
});
