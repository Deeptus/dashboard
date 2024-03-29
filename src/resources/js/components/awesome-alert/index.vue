<template>
    <div class="awesome-alert" v-if="display">
        <div class="awesome-alert__container">
            <div class="awesome-alert__icon"><i :class="icon" :style="'color: ' + iconColor"></i></div>
            <div class="awesome-alert__title" v-html="title"></div>
            <div class="awesome-alert__buttons">
                <button class="awesome-alert__button" v-for="(button, key) in buttons" :key="key" :class="button.class" @click="btnClick(button)" v-html="button.text"></button>
            </div>
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
            display: false,
            interval: false,
            closeTimeout: false,
            buttons: [],
            e: { componentCallback: {} }
        }
    },
    methods: {
        /*
        * Example call:
        aa().open({style: 'success', title: 'Alert Text', buttons: [
            {
                text: "OK",
                value: '19',
                visible: true,
                class: "btn-primary",
                closeModal: true
            },
            {
                text: "SIUEEE",
                value: '13',
                visible: true,
                class: "btn-danger",
                closeModal: true
            }
        ] })
        .then(response => {
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
        */
        open({ style = '', icon = '', iconColor = '', title = '', buttons = [], sleep = false }) {
            this.e.componentCallback.promise = new Promise((resolve, reject) => {
                Object.assign(this.e.componentCallback, { resolve, reject })
            })

            /*
            example for buttons:
                {
                    text: "OK",
                    value: true,
                    visible: true,
                    class: "",
                    closeModal: true,
                    action: () => {
                        // this.close()
                    }
                }
            */
            this.buttons = buttons;
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
            if (this.interval) {
                clearInterval(this.interval)
            }
            if (title != '') {
                this.title     = '<span>' + title + '</span>'
            } else {
                let counter = 1
                this.title = '<span>' + '.'.repeat(counter) + ' Cargando ' + '.'.repeat(counter) + '</span>'
                this.interval = setInterval(() => {
                   this.title = '<span>' + '.'.repeat(counter) + ' Cargando ' + '.'.repeat(counter) + '</span>'
                   counter = counter == 3 ? 1 : counter + 1
                }, 1000)
            }
            this.icon      = icon
            this.iconColor = iconColor
            this.display = true
            if (sleep) {
                clearTimeout(this.closeTimeout)
                this.closeTimeout = setTimeout(() => {
                    this.close()
                }, sleep)
            } else {
                clearTimeout(this.closeTimeout)
            }
            return this.e.componentCallback.promise
        },
        btnClick(button) {
            if (button.closeModal) {
                this.e.componentCallback.resolve(button.value)
                this.close()
            }
            if (button.action) {
                button.action()
            }
        },
        close() {
            this.display = false
            if (this.interval) {
                clearInterval(this.interval)
            }
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
            min-width: 400px;
            width: calc(100% - 60px);
            max-width: fit-content;
            min-height: 240px;
            background-color: #fff;
            box-shadow: 0 0 6px #000;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 18px;
        }
        &__icon {
            font-size: 44px;
        }
        &__title {
            font-size: 30px;
            text-align: center;
            line-height: 33px;
        }
        &__buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            margin-top: 5px;
            width: 100%;
            flex-wrap: wrap;
            padding: 0 15px;
        }
        &__button {
            margin: 2.5px;
        }
    }
</style>