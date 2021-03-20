import Vue from 'vue'
import axios from 'axios'
window.Vue = require('vue');

import PrimeVue from 'primevue/config';
window.Vue.use(PrimeVue);

import 'primevue/resources/themes/nova/theme.css'
import 'primevue/resources/primevue.min.css';
import 'primeflex/primeflex.css';
import './assets/layout/layout.scss';
import './assets/layout/flags/flags.css';
import 'primevue/resources/primevue.min.css';


import Slider from 'primevue/slider';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import Message from 'primevue/message';
import Button from 'primevue/button';
import AutoComplete from 'primevue/autocomplete';
import DataView from 'primevue/dataview';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import Chips from 'primevue/chips';
import InputSwitch from 'primevue/inputswitch';
import InputMask from 'primevue/inputmask';
import InputNumber from 'primevue/inputnumber';
import MultiSelect from 'primevue/multiselect';
import Dropdown from 'primevue/dropdown';
import Card from 'primevue/card';
import Dialog from 'primevue/dialog';
import Toolbar from 'primevue/toolbar';
import ProgressBar from 'primevue/progressbar';
import RadioButton from 'primevue/radiobutton';
import FileUpload from 'primevue/fileupload';
import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions';
import ConfirmationService from 'primevue/confirmationservice';
import ConfirmDialog from 'primevue/confirmdialog';
import Editor from 'primevue/editor';
import SelectButton from 'primevue/selectbutton';
import Checkbox from 'primevue/checkbox';
import Carousel from 'primevue/carousel';
import Divider from 'primevue/divider';
import Vuelidate from 'vuelidate'
import moment from 'moment'
import App from './App.vue';

import router from './router';

window.Vue.use(ConfirmationService);
window.Vue.use(ConfirmDialog);
window.Vue.use(ToastService);
window.Vue.use(Message);

window.Vue.use(moment)
window.Vue.use(Vuelidate)

window.Vue.component('Carousel', Carousel);
window.Vue.component('Checkbox', Checkbox);
window.Vue.component('SelectButton', SelectButton);
window.Vue.component('Editor', Editor);
window.Vue.component('Toast', Toast);
window.Vue.component('DataViewLayoutOptions', DataViewLayoutOptions);
window.Vue.component('InputSwitch', InputSwitch);
window.Vue.component('AutoComplete', AutoComplete);
window.Vue.component('Chips', Chips);
window.Vue.component('InputMask', InputMask);
window.Vue.component('FileUpload', FileUpload);
window.Vue.component('InputNumber', InputNumber);
window.Vue.component('MultiSelect', MultiSelect);
window.Vue.component('RadioButton', RadioButton);
window.Vue.component('Card', Card);
window.Vue.component('Toolbar', Toolbar);
window.Vue.component('Toolbar', Toolbar);
window.Vue.component('Dialog', Dialog);
window.Vue.component('Button', Button);

window.Vue.component('Calendar', Calendar);
window.Vue.component('Dropdown', Dropdown);
window.Vue.component('Column', Column);
window.Vue.component('DataTable', DataTable);
window.Vue.component('DataView', DataTable);
window.Vue.component('InputText', InputText);
window.Vue.component('Divider', Divider);
//window.Vue.component('Slider', Divider);
import ToggleButton from 'primevue/togglebutton';
window.Vue.component('ToggleButton', ToggleButton);
import Chip from 'primevue/chip';
window.Vue.component('Chip', Chip);

window.Vue.component('dashtable', require('./components/DashTable.vue').default)
window.Vue.component('users', require('./components/users/index.vue').default)

 const eventHub = new Vue() // Single event hub

 // Distribute to components using global mixin
 Vue.mixin({
     data: function () {
         return {
             eventHub: eventHub
         }
     }
 })

 Vue.filter('toMoney', function (value) { 
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")

  })

Vue.component('file-manager', require('./components/file-manager').default);


new Vue({
    router,


    render: h => h(App)
}).$mount('#app');
