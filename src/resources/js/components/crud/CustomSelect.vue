<template>
    <div class="custom-select">
        <div class="custom-select__input" @click.self="toggle" :class="{ 'custom-select__input--active': state == 'open', 'custom-select__input--multiple': multiple == true }">
            <label class="custom-select__label" @click.self="toggle">{{ label }}</label>
            <div class="custom-select__selected" @click.self="toggle">
                <span v-if="optionSelected && multiple == false">{{ optionSelected.text }}</span>
                <template v-if="multiple == true">
                    <div v-for="(item, index) in optionSelected" :key="index" class="custom-select__selected-item">
                        <div class="custom-select__selected-item-remove" @click="remove(item)"><i class="fas fa-trash-alt"></i></div>
                        {{ item.text }}
                    </div>
                </template>
            </div>
            <input class="custom-select__select"
                type="text"
                @keyup.enter.prevent="toggle"
                @keypress="toggle"
                @keydown="toggle"
                @focus="toggle"
            />
        </div>
        <div class="custom-select__options" v-if="state == 'open'">
            <input
                type="search"
                class="custom-select__search"
                placeholder="Buscar..."
                v-model="search"
                @keyup.enter="search" ref="search"
                @keyup.esc="toggle"
                @keyup.up="up"
                @keyup.down="down"
            >
            <!--@blur="toggle"-->
            <div
                class="custom-select__option"
                v-for="(option, key) in optionsFiltered"
                :key="key"
                @click="select(option)"
                :class="{
                    'custom-select__option--disabled': option.disabled == true,
                    'custom-select__option--selected': value == option.key
                }"
            >
                {{ option.text }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        options: {
            type: Array,
            required: true
        },
        multiple: {
            type: Boolean,
            default: false
        },
        endpoint: {
            type: String,
            default: ''
        },
        label: {
            type: String,
            default: ''
        },
        value: {},
    },
    data() {
        return {
            state: 'closed',
            search: '',
            optionSelected: {}
        }
    },
    created() {
        if ( this.multiple == false ) {
            if (this.value) {
                this.optionSelected = this.getOptionSelected(this.value);
            }
        } else {
            if ( Object.prototype.toString.call( this.optionSelected ) != '[object Array]' ) {
                this.optionSelected = []
                this.optionSelected.push( ...this.getOptionSelected(this.value) )
                //
                // Aca se escucha si cambian las opciones validas,
                // para asi remover las opciones seleccionadas que no esten en las opciones validas
                this.$watch('options', () => {
                    this.optionSelected = this.optionSelected.filter( (option) => {
                        return this.options.find( option2 => option2.key == option.key )
                    })
                    this.$emit('input', this.optionSelected.map(item => item.key))
                })
            }
        }
    },
    methods: {
        toggle() {
            // if ( this.multiple == false ) {
                this.state = this.state == 'open' ? 'closed' : 'open'
                if (this.state == 'open') {
                    setTimeout(() => {
                        this.$refs.search.focus()
                    }, 100)
                }
            // }
        },
        select(option) {
            if (option.disabled == true) {
                return
            }
            this.state = 'closed'
            if ( this.multiple == false ) {
                this.optionSelected = option
                this.$emit('input', option.key)
            } else {
                this.optionSelected.push(option)
                this.$emit('input', this.optionSelected.map(item => item.key))
            }
        },
        up() {
            let index = this.optionsFiltered.indexOf(this.optionSelected)
            if (index == 0) {
                return
            }
            this.optionSelected = this.optionsFiltered[index - 1]
        },
        down() {
            let index = this.optionsFiltered.indexOf(this.optionSelected)
            if (index == this.optionsFiltered.length - 1) {
                return
            }
            this.optionSelected = this.optionsFiltered[index + 1]
        },
        remove(option) {
            this.optionSelected = this.optionSelected.filter(item => item.key != option.key)
            this.$emit('input', this.optionSelected.map(item => item.key))
        },
        getOptionSelected(value) {
            let option
            if (this.multiple == false) {
                option = this.options.find( o => o.key == value )
            } else {
                //
                // el value lo verifico con filter y no con includes,
                // porque includes no ignora el tipo de dato
                option = this.options.filter( o => value.filter( v => v == o.key ).length > 0 )
            }
            return option
        },
    },
    computed: {
        optionsFiltered() {
            return this.options.filter(option => {
                if ( this.multiple == false ) {
                    try {
                        return option.text.toLowerCase().indexOf(this.search.toLowerCase()) > -1
                    } catch (error) {
                        console.log(option)
                    }
                } else {
                    return option.text.toLowerCase().indexOf(this.search.toLowerCase()) > -1 && this.optionSelected.find(item => item.key == option.key) == undefined
                }
            })
        }
    }
}
</script>
<style lang="scss" scoped>
    .custom-select {
        position: relative;
        height: 100%;
        &__input {
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: 1px solid #cbc8d0;
            cursor: pointer;
            padding: 10px 12px;
            height: 100%;
            text-align: left;
            position: relative;
            user-select: none;
            &--active {
                border-color: #007bff;
                outline: 0;
                box-shadow: 0 0 0 0.25rem rgb(0 123 255 / 25%);
            }
            &--multiple {
                // icon multiple checks
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3C!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --%3E%3Cpath d='M505 174.8l-39.6-39.6c-9.4-9.4-24.6-9.4-33.9 0L192 374.7 80.6 263.2c-9.4-9.4-24.6-9.4-33.9 0L7 302.9c-9.4 9.4-9.4 24.6 0 34L175 505c9.4 9.4 24.6 9.4 33.9 0l296-296.2c9.4-9.5 9.4-24.7.1-34zm-324.3 106c6.2 6.3 16.4 6.3 22.6 0l208-208.2c6.2-6.3 6.2-16.4 0-22.6L366.1 4.7c-6.2-6.3-16.4-6.3-22.6 0L192 156.2l-55.4-55.5c-6.2-6.3-16.4-6.3-22.6 0L68.7 146c-6.2 6.3-6.2 16.4 0 22.6l112 112.2z'/%3E%3C/svg%3E");
            }
        }
        &__label {
            color: rgba(68, 68, 68, 0.65);
            font-size: 0.8rem;
            font-weight: 400;
            position: absolute;
            top: 7px;
            cursor: pointer;
        }
        &__option {
            padding: 8px 12px;
            cursor: pointer;
            user-select: none;
            text-align: left;
            border-bottom: 1px solid #cbc8d0;
            width: 100%;
            color: #343a40;
            background-color: #fff;
            &--disabled {
                color: rgba(68, 68, 68, 0.65);
                background-color: #fafafa;
                cursor: not-allowed;
            }
            &:hover, &--selected {
                background: #f5f5f5;
            }
        }
        &__options {
            position: absolute;
            background: #FFF;
            width: 100%;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #cbc8d0;
            max-height: 300px;
            overflow-x: auto;
            z-index: 1;
        }
        &__search {
            padding: 8px 12px;
            cursor: pointer;
            user-select: none;
            text-align: left;
            border: none;
            border-bottom: 1px solid #cbc8d0;
            width: 100%;
            color: #343a40;
            background-color: #fff;
            outline: none;
            &:focus {
                outline: none;
            }
        }
        &__selected {
            margin-top: 15px;
            max-width: calc(100% - 30px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 21px;
            &-item {
                padding: 0 8px 0 0;
                border: 1px solid #cbc8d0;
                margin: 0 1.5px;
                cursor: auto;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                &-remove {
                    padding: 5px 8px;
                    cursor: pointer;
                    border-right: 1px solid #cbc8d0;
                    margin-right: 8px;
                    color: #343a40;
                    &:hover {
                        background: #c5c5c5;
                        color: #000;
                    }
                }
            }
        }
        &__select {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }
    }
</style>