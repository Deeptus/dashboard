import Vue from 'vue'

window.Vue = Vue

Vue.component('dynamic-content-form', require('./components/dynamic-content/DynamicContentFormComponent.vue').default);
Vue.component('input-file-image', require('./components/InputFileImageComponent.vue').default);
Vue.component('login-form-modal', require('./components/LoginFormModalComponent.vue').default);

Vue.component('crud-generator-form', require('./components/crud-generator/index.vue').default);

Vue.component('chat-area', require('./components/chat/index.vue').default);
Vue.component('button-chat-open', require('./components/chat/buttonOpen.vue').default);

// Vue.component('company-data-form', require('./components/company-data/CompanyDataFormComponent.vue').default);

Vue.component('crud-form', require('./components/crud/index.vue').default);
Vue.component('InputLayout', require('./components/crud/InputLayout.vue').default);

Vue.component('select2', require('./components/Select2Component.vue').default);

Vue.component('file-manager', require('./components/file-manager').default);
Vue.component('CustomGallery', require('./components/CustomGalleryComponent').default);

Vue.component('homework-show', require('./components/homework/show.vue').default);
Vue.component('homework-crud', require('./components/homework/crud.vue').default);
Vue.component('homework', require('./components/homework').default);
Vue.component('awesome-alert', require('./components/awesome-alert').default);

window.aa = (prams) => {
    window.vueApp.$root.$refs['awesome-alert'].open(prams)
}

window.toCurrency = (numero) => {
    let decimales = 2

    let separadorDecimal = document.head.querySelector('meta[name="decimal-separator"]');
    if (separadorDecimal) {
        separadorDecimal = separadorDecimal.content;
    } else {
        separadorDecimal = ','
    }

    let separadorMiles = document.head.querySelector('meta[name="thousands-separator"]');
    if (separadorMiles) {
        separadorMiles = separadorMiles.content;
    } else {
        separadorMiles = '.'
    }

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
}
window.getFileSize = (file, param = '') => {
    if (file && file instanceof File) {

        if (param.search('h') > -1) {
            if (file.size / (1024 * 1024) > 1024 ) {
                return window.toCurrency(file.size / 1024 / 1024 / 1024)+'gb'
            }
            
            if (file.size / 1024 > 1024 ) {
                return window.toCurrency(file.size / 1024 / 1024)+'mb'
            }

            return window.toCurrency(file.size / 1024)+'kb'
        }

        return file.size/1024
    }

    return 0
}
window.getValidFileSize = (param = '') => {
    let maxFileSize = document.head.querySelector('meta[name="3c3aazbg5"]');
    if (maxFileSize) {
        maxFileSize = parseFloat(maxFileSize.content)-50;
    } else {
        maxFileSize = 128
    }
    if (param.search('h') > -1) {
        if (maxFileSize > 1024) {
            return window.toCurrency(maxFileSize / 1024)+'mb'
        }
        return window.toCurrency(maxFileSize)+'kb'
    }
    return maxFileSize
}
window.getPostMaxSize = (param = '') => {
    let postMaxSize = document.head.querySelector('meta[name="f983jd020"]');
    if (postMaxSize) {
        postMaxSize = parseFloat(postMaxSize.content)-50;
    } else {
        postMaxSize = 128
    }
    if (param.search('h') > -1) {
        if (postMaxSize > 1024) {
            return window.toCurrency(postMaxSize / 1024)+'mb'
        }
        return window.toCurrency(postMaxSize)+'kb'
    }
    return postMaxSize
}
window.checkValidFileSize = (file) => {
    if (window.getFileSize(file) > window.getValidFileSize()) {
        return false
    }
    return true
}

window.replaceAll = (str, searchStr, replaceStr) => {
    // no match exists in string?
    if (str.indexOf(searchStr) === -1) {
        // return string
        return str;
    }

    // replace and remove first match, and do another recursirve search/replace
    return replaceAll(
        str.replace(searchStr, replaceStr),
        searchStr,
        replaceStr
    );
}

window.storagePath = (file) => {
    let storagePath = document.head.querySelector('meta[name="storage-path"]').content
    let url         = storagePath + '/\\' + file
    url = replaceAll(url, '\\', '/')
    return replaceAll(url, '//', '/')
}
// trim custon chars
String.prototype.trimChars = function (c) {
    var re = new RegExp("^[" + c + "]+|[" + c + "]+$", "g");
    return this.replace(re,"");
}
window.slugify = (text, divider = '-') => {
    text = text
        .toString()       // Cast to string
        .toLowerCase()    // Convert the string to lowercase letters
        .normalize('NFD') // The normalize() method returns the Unicode Normalization Form of a given string.
        // .trim()           // Remove whitespace from both sides of a string
        .trimChars(' ')
        .trimChars('_')

    if (divider == '-') {
        text = text
            .replace(/\s+/g, '-')     // Replace spaces with -
            .replace(/[^\w\-]+/g, '') // Remove all non-word chars
            .replace(/\-\-+/g, '-');  // Replace multiple - with single -
    }
    if (divider == '_') {
        text = text
            .replace(/\s+/g, '_')     // Replace spaces with _
            .replace(/[^\w\-]+/g, '') // Remove all non_word chars
            .replace(/\-+/g, '_')     // Replace multiple - with single -
            .replace(/\_\_+/g, '_');  // Replace multiple - with single -
    }
    return text
        // just in case
        .trimChars(' ')
        .trimChars('_')
}
Vue.filter('toCurrency',         window.toCurrency);
Vue.filter('getFileSize',        window.getFileSize);
Vue.filter('getPostMaxSize',     window.getPostMaxSize);
Vue.filter('checkValidFileSize', window.checkValidFileSize);
Vue.filter('getValidFileSize',   window.getValidFileSize);
Vue.filter('storagePath',        window.storagePath);
// import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.mixin({
  methods: {
    aa(prams) {
        window.aa(prams)
    },
    fileManager() {
        return this.$root.$refs.FileManager
    },
    closeChat(uuid) {
        return this.$root.$refs.chatArea.closeChat(uuid)
    },
    openChat(params) {
        return this.$root.$refs.chatArea.openChat(params)
    },
    homeworkShow(uuid) {
        return this.$root.$refs.homeworkShow.open(uuid)
    },
    slugify(text, divider = '-') {
        return window.slugify(text, divider)
    },
    storagePath(file) {
        return window.storagePath(file)
    },
    toCurrency(numero) {
        return window.toCurrency(numero)
    },
    getPostMaxSize(param) {
        return window.getPostMaxSize(param)
    },
    getFileSize(file, param) {
        return window.getFileSize(file, param)
    },
    checkValidFileSize(file) {
        return window.checkValidFileSize(file)
    },
    getValidFileSize(param) {
        return window.getValidFileSize(param)
    },
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
  },
  created() {
    window.vueApp = this
  }
})

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

// Vue.use( CKEditor );
// import { ValidationProvider } from 'vee-validate';

// Vue.component('ValidationProvider', ValidationProvider);

/*********************************************************************
 * 
 * Renovar token
 * 
*********************************************************************/
window.csrfUpdateCounter = 0
class Csrf {
    async refresh() {
        if  (window.csrfUpdateCounter >= 3) {
            throw new Error('Refresh limit exceeded');
        }
        window.csrfUpdateCounter ++
        let publicPath = document.head.querySelector('meta[name="public-path"]').content
        let tokenPath  = publicPath + 'refresh-csrf'
        await axios.get(tokenPath).then((response) => {
            document.querySelector('meta[name="csrf-token"]').setAttribute("content", response.data);
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data
            console.log('%c Se actualizo el csrf', 'background: #32a852; color: #ffffff')
        }).catch((error) => {
            if (error.response.data.message == 'Unauthenticated.') {
                throw new Error('Unauthenticated.');
            }
            console.log('%c error al refrescar csrf', 'background: #a83232; color: #ffffff')
        })
        return true
    }
}
window.csrf = (new Csrf)