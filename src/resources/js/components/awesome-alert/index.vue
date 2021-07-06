<template>
    <div class="awesome-alert" v-if="display">
        <div class="awesome-alert__container">
            <div class="awesome-alert__icon"><i :class="icon" :style="'color: ' + iconColor"></i></div>
            <div class="awesome-alert__title" v-html="title"></div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            icon: '',
            iconColor: '',
            display: false
        }
    },
    methods: {
        /*
        example for buttons:
            {
                text: "OK",
                value: true,
                visible: true,
                className: "",
                closeModal: true
            }
        */
        open({ style = '', icon = '', iconColor = '', title = '', buttons = [] }) {
            const styles = [
                {
                    slug: 'loading',
                    icon: 'fas fa-spinner fa-pulse',
                    iconColor: '#6c757d'
                },
                {
                    slug: 'success',
                    icon: 'fas fa-check',
                    iconColor: '#a5dc86'
                },
                {
                    slug: 'error',
                    icon: 'fas fa-times',
                    iconColor: '#dc3545'
                },
                {
                    slug: 'warning',
                    icon: 'fas fa-exclamation',
                    iconColor: '#ffc107'
                },
                {
                    slug: 'info',
                    icon: 'fas fa-info',
                    iconColor: '#0dcaf0'
                },
                {
                    slug: 'question',
                    icon: 'fas fa-question',
                    iconColor: '#6c757d'
                },
            ]
            style = styles.find( s => s.slug == style )
            if (style) {
                icon      = style.icon
                iconColor = style.iconColor
            }
            this.title     = '<span>' + title + '</span>'
            this.icon      = icon
            this.iconColor = iconColor
            this.display = true
        },
        close() {
            this.display = false
        }
    }
}
</script>

<style lang="scss" scoped>
    .awesome-alert {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
        background: rgba(0,0,0,.5);
        z-index: 999999999;
        display: flex;
        justify-content: center;
        align-items: center;
        &__container {
            width: 400px;
            height: 240px;
            background-color: #fff;
            box-shadow: 0 0 6px #000;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-size: 44px;
        }
        &__title {
            font-size: 30px;
            text-align: center;
            line-height: 33px;
        }
    }
</style>