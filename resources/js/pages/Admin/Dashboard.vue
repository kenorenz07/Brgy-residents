<template>
     <div class="m-2">
     <v-card
            class="mx-auto px-5 py-5"
            outlined
        >
            <v-card-text>
                <v-tabs
                    v-model="tab"
                    align-with-title
                >
                    <v-tabs-slider></v-tabs-slider>

                    <v-tab
                        v-for="item in items"
                        :key="item"
                    >
                        {{ item }}
                    </v-tab>
                </v-tabs>

                <v-tabs-items v-model="tab">
                    <v-tab-item
                        v-for="item in items"
                        :key="item"
                    >
                        <v-card
                            class="mx-auto px-5 py-5"
                            outlined
                        >
                            <v-row v-if="item == 'Statistics'">
                                <v-col cols=3>
                                    <v-card elevation="3" @click="goTo('/students')">
                                        <v-card-text>
                                            <div class="d-flex justify-space-between mx-2">
                                                <div >
                                                    <v-icon color="primary" style="font-size:100px">
                                                        mdi-account-group
                                                    </v-icon>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="text-right text-subtitle-1">
                                                        4p's members
                                                    </div>
                                                    <p class="text-right text-h4">
                                                        {{statistics_totals.four_p_members}}
                                                    </p>
                                                </div>
                                            </div>
                                        </v-card-text>
                                    </v-card>
                                    </v-col>
                                    <v-col cols=3>
                                        <v-card elevation="3" @click="goTo('/class-details')">
                                            <v-card-text>
                                                <div class="d-flex justify-space-between mx-2">
                                                    <div >
                                                        <v-icon color="secondary" style="font-size:100px">
                                                            mdi-account-supervisor
                                                        </v-icon>
                                                    </div>
                                                    <div class="mt-3">
                                                        <div class="text-right text-subtitle-1">
                                                            Senior Citizens
                                                        </div>
                                                        <p class="text-right text-h4">
                                                            {{statistics_totals.seniors}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                    <v-col cols=3>
                                        <v-card elevation="3" >
                                            <v-card-text>
                                                <div class="d-flex justify-space-between mx-2">
                                                    <div >
                                                        <v-icon color="info" style="font-size:100px">
                                                            <!-- mdi-hospital-box -->
                                                            mdi-hospital
                                                        </v-icon>
                                                    </div>
                                                    <div class="mt-3">
                                                        <div class="text-right text-subtitle-2">
                                                            Vaccinated
                                                        </div>
                                                        <p class="text-right text-h4">
                                                            {{statistics_totals.vaccinated}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                    <v-col cols=3>
                                        <v-card elevation="3" >
                                            <v-card-text>
                                                <div class="d-flex justify-space-between mx-2">
                                                    <div >
                                                        <v-icon color="info" style="font-size:100px">
                                                            mdi-home-city
                                                        </v-icon>
                                                    </div>
                                                    <div class="mt-3">
                                                        <div class="text-right text-subtitle-2">
                                                            Households
                                                        </div>
                                                        <p class="text-right text-h4">
                                                            {{statistics_totals.households}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </v-card-text>
                                        </v-card>
                                </v-col>
                            </v-row>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data: () => ({
        statistics_totals : {
            households : 10,
            four_p_members : 40,
            seniors : 20,
            vaccinated : 40,
        },
        tab: null,
        items: [
          'Statistics', 'Map'
        ],
    }),
    watch : {
    },
    computed : {
    },
    mounted() {
        // this.forceRerender();
        this.initialize()

    },
    methods: {
        initialize(){
   
        },
        goTo(path) {
            this.$router.push(path)
        }
    },
   
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