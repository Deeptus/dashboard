<template>
    <div class="position-relative">
        <button class="badge debug-btn" :class="{ 'bg-secondary': debug, 'bg-info': !debug }" @click="debug = !debug"><i class="fas fa-bug"></i></button>
        <div class="card" v-if="debug">
            <div class="card-header">
                <h4 class="card-title">content</h4>
            </div>
            <div class="card-body">
                <pre>{{ content }}</pre>
            </div>
            <div class="card-header">
                <h4 class="card-title">value</h4>
            </div>
            <div class="card-body">
                <pre>{{ value }}</pre>
            </div>
            <div class="card-header">
                <h4 class="card-title">input</h4>
            </div>
            <div class="card-body">
                <pre>{{ input }}</pre>
            </div>
        </div>
        <component :is="input.columnname.replace('_', '-')" :value="value" :input="input" :content="content"></component>
    </div>
</template>

<script>
export default {
    name: 'CustomComponent',
    props: {
        content: {
            type: Object,
            required: true,
            default: {}
        },
        value: {
            type: Object,
            required: true,
            default: {}
        },
        input: {
            type: Object,
            required: true,
            default: {}
        }
    },
    data() {
        return {
            debug: false
        }
    },
    methods: {
        //
    }
}
</script>

<style lang="scss" scoped>
.debug-btn {
    position: absolute;
    right: 0;
    top: 0;
    font-size: 10px;
    z-index: 1;
}
</style>