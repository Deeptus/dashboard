<template>
    <div v-bind="properties">
        <template v-if="state.state == 'list' && layout == 'dropdown'">
            <div  class="dropdown-item" v-for="(record, key) in state.records" :key="key" @click="open(record.id)">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 overflow-hidden">{{ record.data.title }}</h5>
                    <small class="ps-2">{{ record.created_at_ago }}</small>
                </div>
                <p class="mb-1 overflow-hidden" v-if="3==4">Some placeholder content in a paragraph.</p>
                <small>{{ record.data.message }}</small>
            </div>
        </template>
        <table class="table table-hover table-sm" v-if="layout == 'table'">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(record, key) in state.records" :key="key" @click="open(record.id)" class="cursor-pointer">
                    <td>{{ record.data.title }}</td>
                    <td>{{ record.data.message }}</td>
                    <td>{{ record.created_at_ago }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        layout: {
            type: String,
            default: 'dropdown'
        },
    },
    components: {},
    data() {
        return {
            endpoint: '',
            properties: {},
            state: {
                state: 'loading'
            }
        }
    },
    created () {
        this.endpoint = window.apis.notification;
        if (this.layout == 'dropdown') {
            // class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="notificationsDropdown"
            this.properties = {
                class: 'dropdown-menu dropdown-menu-end shadow animated--grow-in',
                'aria-labelledby': 'notificationsDropdown'
            }
        }
        axios.get(this.endpoint).then((response) => {
            this.state.records = response.data
            this.state.state = 'list'
        })
    },
    methods: {
        add() {
            this.state.state = 'add'
        },
        open(id) {
            this.$root.$refs.notificationShow.open(id)
        }
    }
}
</script>
<style lang="scss" scoped>
    .dropdown-menu {
        width: 300px !important;
    }
    .dropdown-item {
        cursor: pointer;
        user-select: none;
    }
    h5 {
        font-weight: bold;
        font-size: 1rem;
    }
    .detail-modal {
        background-color: rgba($color: #000000, $alpha: .4);
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        &__container {
            position: sticky;
            top: 50px;
            background-color: #ffffff;
            overflow: hidden;
        }
        &__body {
            border-bottom: 1px solid #cbc8d0;
            border-top: 1px solid #cbc8d0;
            margin-top: 9px;
            margin-bottom: 16px;
        }
        &__footer {
            margin-bottom: 1.5rem;
        }
        &__header {
            margin-top: 1rem;
            font-size: 20px;
            font-weight: 600;
        }
    }
</style>