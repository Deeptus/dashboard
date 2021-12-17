<template>
    <div>
        <label class="form-label" :for="nameKey">{{ input.label }}</label>
        <div class="input-group has-validation">
            <select
                v-if="type == 'select'"
                :class="{ 'form-select': true, 'is-invalid': input.errors && input.errors.length > 0 }"
                :id="nameKey"
                :name="nameKey"
                :disabled="input.disabled"
                v-model="input.value"
            >
                <option :value="option.key" v-for="(option, index) in input.options" :key="index">{{ option.text }}</option>
            </select>
            <div class="invalid-feedback" v-for="(error, ekey) in input.errors" :key="ekey" v-html="error"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        input: {},
        type: {
            default: 'select'
        }
    },
    created() {
        this.$nextTick(() => {
            this.nameKey = (Math.random() + 1).toString(36).substring(2)
        });
    },
    data(){
        return {
            nameKey: ''
        }
    }
}
</script>

<style>

</style>