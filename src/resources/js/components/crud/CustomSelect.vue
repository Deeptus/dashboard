<template>
    <div class="custom-select">
        <div class="custom-select__input" @click="toggle" :class="{'custom-select__input--active': state == 'open'}">
            <label class="custom-select__label">{{ label }}</label>
            <div class="custom-select__selected">
                {{ optionSelected.text }}
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
        if (this.value) {
            this.optionSelected = this.getOptionSelected(this.value);
        }
    },
    methods: {
        toggle() {
            this.state = this.state == 'open' ? 'closed' : 'open'
            if (this.state == 'open') {
                setTimeout(() => {
                    this.$refs.search.focus()
                }, 100)
            }
        },
        select(option) {
            if (option.disabled == true) {
                return
            }
            this.state = 'closed'
            this.optionSelected = option
            this.$emit('input', option.key)
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
        getOptionSelected(value) {
            let option = this.options.find(option => option.key == value)
            return option
        },
    },
    computed: {
        optionsFiltered() {
            return this.options.filter(option => {
                return option.text.toLowerCase().indexOf(this.search.toLowerCase()) > -1
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