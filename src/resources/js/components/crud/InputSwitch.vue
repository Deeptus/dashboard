<template>
    <div class="switch" :class="{ 'switch--true': checkActive() }" @click="change()">
        <span class="switch__text" v-if="checkActive()">Si</span>
        <span class="switch__text" v-else>No aplica</span>
    </div>
</template>
<script>

    export default {
        props: {
            value: {},
            val: {}
        },
        components: {},
        data(){
            return{}
        },
        created() {
        },
        mounted () {},
        watch: {},
        methods: {
            change() {
                if (Object.prototype.toString.call( this.value ) == '[object Array]') {
                    let index = this.value.indexOf(this.val)
                    if (index >= 0) {
                        this.value.splice(index, 1)
                    } else {
                        this.value.push(this.val)
                        this.$emit('input', this.value)
                    }
                } else {
                    this.$emit('input', !this.value)
                }
            },
            checkActive() {
                if (Object.prototype.toString.call( this.value ) == '[object Array]') {
                    let index = this.value.indexOf(this.val)
                    return index >= 0
                } else {
                    return this.value
                }
            },
            lang() {
                return document.documentElement.lang
            }
        },
        computed: {
        }
    }

</script>
<style lang="scss" scoped>
    .switch {
        height: 20px;
        width: 90px;
        border: 2px solid #b5b5b5;
        border-radius: 30px;
        background-color: #b5b5b5;
        position: relative;
        cursor: pointer;
        user-select: none;
        display: inline-block;
        &::after {
            content: "";
            height: 16px;
            width: 16px;
            border-radius: 50%;
            background-color: #FFF;
            position: absolute;
            transform: translate(0, 0);
            transition: all .3s ease;
            top: 0;
            left: 0;
        }
        &__text {
            font-weight: bold;
            color: #464646;
            font-size: 13px;
            position: absolute;
            left: 20px;
            width: 60px;
            text-align: center;
            white-space: nowrap;
        }
        &--true {
            border: 2px solid #0d6efd;
            background-color: #0d6efd;
            &::after {
                transform: translate(70px, 0);
            }
            .switch__text {
                left: 8px;
                color: #FFF;
            }
        }
    }
</style>
