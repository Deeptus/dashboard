 <template>
    <div class="">
        <div class="card-header">Material {{item}}</div>
        <div class="card-body">
            <div class="row" v-for="(item,indexMaterial) in material" :key="indexMaterial">
                <div class="form-group col-md-3">
                    <label>Pieza</label>
                    <select v-model="item.pieza" class="form-control" :id="'pieza-'+indexMaterial">
                        <option value="0">SELECCIONE</option>
                        <option
                        :value="superficie.id"
                        v-for="(superficie, index) in superficies"
                        >
                            {{ superficie.description }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Material</label>
                    <div class="selectpicker-form-group">
                        <select v-model="item.material" class="selectpicker" style="width: 100%" data-live-search="true" @change="changeMaterial(item)" :disabled="item.pieza==0">
                            <option value="0">
                                SELECCIONE
                            </option>
                            <option
                            :value="material.id"
                            v-for="(material, index) in materiales"
                            >
                                {{ material.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-2" v-if="item.pieza!=0 && item.material > 0">
                    <label>Existencia</label>
                    <div class="form-control">Disponible</div>
                </div>
                <div class="form-group col-md-3" v-if="item.pieza!=0 && item.material > 0">
                    <label>Observaciones</label>
                    <div class="form-control">{{ piezeDescription(item) }}</div>
                </div>
                <div class="col-md-3" v-if="item.pieza!=0 && item.material > 0">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Largo en metros</label>
                            <input type="text" v-model.number="item.largometros" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ancho en metros</label>
                            <input type="text" v-model.number="item.anchometros" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-3" v-if="item.pieza!=0 && item.material > 0">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Metros cuadrados</label>
                            <input type="text" v-model="item.largometros*item.anchometros" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-6" v-if="displayPrice()">
                            <label>Precio material</label>
                            <div class="form-control">{{ calcIvaMarkup(piezePrice(item)) | toCurrency }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-2" v-if="item.pieza!=0 && item.material > 0">
                    <label>Adicional</label>
                    <div class="form-control">
                        <div class="custom-control custom-checkbox col-md-4" v-if="isLeather(item)">
                            <input
                            type="checkbox"
                            v-bind:true-value="1"
                            v-bind:false-value="0"
                            v-model.number="item.adicional"
                            class="custom-control-input"
                            :id="'adicional-'+indexMaterial"
                            >
                            <label class="custom-control-label" :for="'adicional-'+indexMaterial">Leather</label>
                        </div>
                        <div class="custom-control custom-checkbox col-md-4" v-if="isRP(item)">
                            <input
                            type="checkbox"
                            v-bind:true-value="2"
                            v-bind:false-value="0"
                            v-model.number="item.adicional"
                            class="custom-control-input"
                            :id="'adicional-'+indexMaterial"
                            disabled=""
                            >
                            <label class="custom-control-label" :for="'adicional-'+indexMaterial">RP</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" v-if="item.pieza!=0 && item.material > 0">
                    <div class="row" v-if="displayPrice()">
                        <div class="form-group col-md-6">
                            <label>Precio adicional</label>
                            <div class="form-control">{{ calcIvaMarkup(piezeAditionalPrice(item)) | toCurrency }}</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Monto en $</label>
                            <div class="form-control">{{ calcIvaMarkup(piezeTotal(item, indexMaterial)) | toCurrency }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1  align-items-end">
                    <button @click="deleteMaterial(indexMaterial)" class="btn btn-danger">X</button>
                </div>
            </div>
            <div class="text-right" v-if="displayPrice()">
                <p><b>Subtotal Material: $ {{ calcIvaMarkup(materialTotal()) | toCurrency }}</b></p>
                <button @click="addMaterial" class="btn btn-success">Agregar</button>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['cliente','material','item','superficies','materiales','adicionales', 'total'],
        data(){
            return{
                piezeTotales: []
            }
        },
        mounted() {
            $('.selectpicker').selectpicker({
                noneResultsText : 'No se encontraron resultados {0}',
            })
        },
        updated: function(){
            this.$nextTick(function(){
                $('.selectpicker').selectpicker('refresh')
            });
        },
        methods:{
            changeMaterial: function (item) {
                if (this.materiales[item.material-1].rp == 1) {
                    item.adicional = 2;
                } else {
                    item.adicional = 0;
                }
            },
            addMaterial: function () {
                this.material.push({
                    pieza: 0,
                    material: 0,
                    existencia: '',
                    observaciones: '',
                    largometros: 0,
                    anchometros: 0,
                    metroscuadrados: '',
                    preciomaterial: '',
                    adicional: 1,
                    precioadicional: '',
                    monto: '',
                });
                this.$root.targetFocus = 'pieza-'+(this.material.length-1);
            },
            deleteMaterial: function (index) {
                this.material.splice(index, 1);
                this.piezeTotales.splice(index, 1);
                if (this.material.length === 0)
                    this.addMaterial()
            },
            piezePrice: function (item) {
                return this.materiales[item.material-1].display_price * (item.largometros*item.anchometros)
            },
            piezeDescription: function (item) {
                return this.materiales[item.material-1].comment
            },
            isLeather: function (item) {
                return this.materiales[item.material-1].leather == 1
            },
            isRP: function (item) {
                var pieza = this.superficies.find(function(element) {
                    return element.id == item.pieza;
                });
                if (this.materiales[item.material-1].rp == 1 && pieza.rp == 1) {
                    return true
                }
                return false
            },
            piezeAditionalPrice: function (item) {
                var adicionales = this.adicionales
                var leather = 0
                var rp = 0
                Object.keys(adicionales).forEach(function(key) {
                    let element = adicionales[key]
                    if (element.code == "MORP") {
                        leather = element.price
                    }
                    if (element.code == "MOTERLTH" && this.isRP(item)) {
                        rp = element.price
                    }
                }.bind(this));
                if(item.adicional == 1)
                    return leather
                if(item.adicional == 2)
                    return rp
            },
            piezeTotal: function (item, index) {
                let piezePrice = this.piezePrice(item)
                let total = 0;
                if(item.adicional == 1){
                    total = this.piezeAditionalPrice(item) + piezePrice
                } else if(item.adicional == 2){
                    total = this.piezeAditionalPrice(item) + piezePrice
                } else {
                    total = piezePrice
                }
                this.piezeTotales[index] = {
                    price: total,
                    m2:    item.largometros*item.anchometros,
                }
                return total
            },
            materialTotal: function () {
                if (this.piezeTotales.length > 0) {
                    var totalPrice = 0
                    var totalM2 = 0
                    this.piezeTotales.forEach(function (item) {
                        totalPrice += item.price
                        totalM2 += item.m2
                    });
                    this.total.material = {
                        price: totalPrice,
                        m2: totalM2,
                    }
                    return totalPrice
                }
                return 0
            }
        },
        computed: {
        }
    }
</script>
