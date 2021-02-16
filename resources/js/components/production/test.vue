<template>
    <div class="container">
<div class="p-fluid p-grid">
    <div class="p-field p-col-12 p-md-4">
        <span class="p-float-label">
            <InputText id="inputtext" type="text" v-model="value1" />
            <label for="inputtext">InputText</label>
        </span>
    </div>
    <div class="p-field p-col-12 p-md-4">
        <span class="p-float-label">
            <AutoComplete v-model="value2" :suggestions="filteredCountries" @complete="searchCountry($event)" field="name" />
            <label for="autocomplete">AutoComplete</label>
        </span>
    </div>
    <div class="p-field p-col-12 p-md-4">
        <span class="p-float-label">
            <Calendar id="calendar" v-model="value3" />
            <label for="calendar">Calendar</label>
        </span>
    </div>
    <div class="p-field p-col-12 p-md-4">
        <span class="p-float-label">
            <chips id="chips" v-model="value4" />
            <label for="chips">Chips</label>
        </span>
    </div>
    <div class="p-field p-col-12 p-md-4">
        <span class="p-float-label">
            <InputMask id="inputmask" v-model="value5" mask="99/99/9999" slotChar="mm/dd/yyyy" />
            <label for="inputmask">InputMask</label>
        </span>
    </div>
    <div class="p-field p-col-12 p-md-4">
        <span class="p-float-label">
            <InputNumber id="inputnumber" v-model="value6" />
            <label for="inputnumber">InputNumber</label>
        </span>
    </div>
    <div class="p-field p-col-12 p-md-4">
        <div class="p-inputgroup">
            <span class="p-inputgroup-addon">
                <i class="pi pi-user"></i>
            </span>
            <span class="p-float-label">
                <InputText id="inputgroup" type="text" v-model="value7" />
                <label for="inputgroup">InputGroup</label>
            </span>
        </div>
    </div>
    <div class="p-field p-col-12 p-md-4">
        <span class="p-float-label">
            <Dropdown id="dropdown" v-model="value8" :options="cities" optionLabel="name" />
            <label for="dropdown">Dropdown</label>
        </span>
    </div>
    <div class="p-field p-col-12 p-md-4">
        <span class="p-float-label">
            <MultiSelect id="multiselect" v-model="value9" :options="cities" optionLabel="name" />
            <label for="multiselect">MultiSelect</label>
        </span>
    </div>
    <div class="p-field p-col-12 p-md-4">
        <span class="p-float-label">
            <Textarea id="textarea" v-model="value10" rows="3" />
            <label for="textarea">Textarea</label>
        </span>
    </div>
</div>

    </div>
</template>

<script>
//import CountryService from '../../service/CountryService';

export default {
    data() {
        return {
            countries: null,
            filteredCountries: null,
            cities: [
                {name: 'New York', code: 'NY'},
                {name: 'Rome', code: 'RM'},
                {name: 'London', code: 'LDN'},
                {name: 'Istanbul', code: 'IST'},
                {name: 'Paris', code: 'PRS'}
            ],
            value1: null,
            value2: null,
            value3: null,
            value4: null,
            value5: null,
            value6: null,
            value7: null,
            value8: null,
            value9: null,
            value10: null
        }
    },
    props: ['data'],
    countryService: null,
    created() {
        //this.countryService = new CountryService();
    },
    mounted() {
        //this.countryService.getCountries().then(data => this.countries = data);
    },
    methods: {
        searchCountry(event) {
            setTimeout(() => {
                if (!event.query.trim().length) {
                    this.filteredCountries = [...this.countries];
                }
                else {
                    this.filteredCountries = this.countries.filter((country) => {
                        return country.name.toLowerCase().startsWith(event.query.toLowerCase());
                    });
                }
            }, 250);
        }
    },
}
</script>
