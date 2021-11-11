/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.getSpsi = () => {
    if(window.spsi) {
        return JSON.parse(window.atob(window.spsi))
    }
    return false
}

window.generateRamdomCuit = () => {
    let cuit = [20, 24, 27, 30, 34][Math.random() * 4.9 | 0] + "" + (Math.random() * 89999999 + 10000000 | 0);
    let suma = 0;
    for (i = 0; i < cuit.length; i++) {
        suma += parseInt(cuit[cuit.length - i - 1]) * (2 + (i % 6));
    }
    let verificador = (x => x == 11 ? 0 : x)(11 - (suma % 11));
    return (verificador == 10 ) ? generar() : "cuit: " + cuit + verificador;
};

import Vue from 'vue'

// VUE
import { VueReCaptcha } from 'vue-recaptcha-v3'
Vue.use(VueReCaptcha, { siteKey: '6LctaZkUAAAAAHIb3UhjrSgDNxtVa_ye3Ut1UwWY' })

//

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

Vue.component('form-contact-request',            require('../../vendor/aporteweb/dashboard/src/resources/js/components/website/contact/index.vue').default);
Vue.component('form-contact-request-input-text', require('../../vendor/aporteweb/dashboard/src/resources/js/components/website/contact/inputs/text.vue').default);

// Vue.component('form-register',       require('./components/website/Auth/FormRegister.vue').default);


window.toCurrency = (numero, decimales = 2) => {
    let separadorDecimal = document.head.querySelector('meta[name="decimal-separator"]')
    if (separadorDecimal) {
        separadorDecimal = separadorDecimal.content
    } else {
        separadorDecimal = ",";
    }
    let separadorMiles   = document.head.querySelector('meta[name="thousands-separator"]')
    if (separadorMiles) {
        separadorMiles = separadorMiles.content
    } else {
        separadorMiles = ".";
    }
    let partes, array;

    if ( !isFinite(numero) || isNaN(numero = parseFloat(numero)) ) {
        return "";
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
}

Vue.filter('toCurrency', window.toCurrency);

Vue.mixin({
    methods: {
        toCurrency(numero, decimales = 2) {
            return window.toCurrency(numero, decimales)
        },
    }
})



import Vuex from 'vuex'

Vue.use(Vuex)

const app = new Vue({
    el: '#app',
    data() {
        return {};
    },
    created() {
        this.$nextTick(() => {
        });
    },
});
