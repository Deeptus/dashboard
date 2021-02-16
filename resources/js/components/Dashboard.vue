<template>
    <div class="container">



    </div>
</template>

<script>
    export default {
        data() {
            return {
                groups: this.$parent.authGroup.map(group => group.id),
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
