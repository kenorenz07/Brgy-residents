<template>
     <div class="m-2">
        <v-card
            class="mx-auto px-5 py-5"
            outlined
        >
            <v-card-text>
               <h1>Tangina mo kenloi</h1>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data : () => ({
        user : {}
    }),
    mounted() {
        this.initialize()
    },
    methods : {
        initialize() {
            this.$admin.get('/profile').then(({data}) => {
                this.user = data
            })
        }
    }
   
};
</script>
<style scoped>
    .statistics-card {
        position: relative;
    }
    .chart-select{
        display: flex;
        position: absolute;
        right: 10px;
        top: 10px;
        z-index: 107!important;
    }
</style>