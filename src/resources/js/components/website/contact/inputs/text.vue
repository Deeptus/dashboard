<template>
    <div>
        <label class="form-label" :for="nameKey">{{ input.label }}</label>
        <div class="input-group has-validation">
            <input
                v-if="type == 'text' || type == 'email'"
                :type="type"
                :class="{ 'form-control': true, 'is-invalid': input.errors && input.errors.length > 0 }"
                :id="nameKey"
                :name="nameKey"
                :disabled="input.disabled"
                v-model="input.value"
            >
            <textarea
                v-if="type == 'textarea'"
                :class="{ 'form-control': true, 'is-invalid': input.errors && input.errors.length > 0 }"
                :id="nameKey"
                :name="nameKey"
                :disabled="input.disabled"
                v-model="input.value"
                rows="5"
            ></textarea>
            <div class="invalid-feedback" v-for="(error, ekey) in input.errors" :key="ekey" v-html="error"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        input: {},
        type: {
            default: 'text'
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