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
                            <v-row v-if="item == 'Map'">
                                <v-col cols="12" md=12 sm=12>
                                    <div style="width:100%;height: 600px">
                                        <LocationSelector v-model="form.location" :key="form.key"  :household_location="user_location" :marker_select="false"/>
                                    </div>
                                </v-col>
                            </v-row>
                            <v-row v-if="item == 'Statistics'">
                                <v-col cols=3 md=3 sm=6>
                                    <v-card elevation="3" >
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
                                <v-col cols=3 md=3 sm=6>
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
                                                        Residents
                                                    </div>
                                                    <p class="text-right text-h4">
                                                        {{statistics_totals.residents}}
                                                    </p>
                                                </div>
                                            </div>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                                <v-col cols=3 md=3 sm=6>
                                    <v-card elevation="3" >
                                        <v-card-text>
                                            <div class="d-flex justify-space-between mx-2">
                                                <div >
                                                    <v-icon color="info" style="font-size:100px">
                                                        mdi-home-group
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
                                <v-col cols=3 md=3 sm=6>
                                    <v-card elevation="3" >
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
                            </v-row>
                            <v-row  v-if="item == 'Statistics'">
                                <v-col cols=4 md=4 sm=6>
                                    <div class="">
                                        <h4 class="ml-10">Gender</h4>
                                        <apexchart type="pie" width="400" :options="genderOptions" :series="gender_series"></apexchart>
                                    </div>
                                </v-col>
                                <v-col cols=4 md=4 sm=6>
                                    <div class="">
                                        <h4 class="ml-10">Vaccinated</h4>
                                        <apexchart type="pie" width="400" :options="vaccinatedOptions" :series="vaccinated_series"></apexchart>
                                    </div>
                                </v-col>
                                <v-col cols=4 md=4 sm=6>
                                    <div class="">
                                        <h4 class="ml-10">Civil Status</h4>
                                        <apexchart type="pie" width="400" :options="civil_statusOptions" :series="civil_status_series"></apexchart>
                                    </div>
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
import LocationSelector from '../../components/LocationMapSelector.vue'

export default {
    data: () => ({
        statistics_totals : {
            households : 10,
            four_p_members : 40,
            residents : 20,
            seniors : 20,
        },
        tab: null,
        items: [
          'Statistics', 'Map'
        ],
        gender_series: [44, 55],
        genderOptions: {
            chart: {
                width: 380,
                type: 'pie',
            },
            legend: {
                        position: 'bottom'
                    },
            labels: ['Male', 'Female'],
            colors: ['#4a4ae4', '#efa3b1'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        },
        vaccinated_series: [44, 55],
        vaccinatedOptions: {
            chart: {
                width: 380,
                type: 'pie',
            },
            legend: {
                        position: 'bottom'
                    },
            labels: ['Vaccinated', 'Not vaccinated'],
            colors: ['#52ff00', '#ea766c'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        },
        civil_status_series: [44, 55,44, 4, 55],
        civil_statusOptions: {
            chart: {
                width: 380,
                type: 'pie',
            },
            legend: {
                        position: 'bottom'
                    },
            labels: ["Married", "Single", "Divorced", "Widowed","Separated"],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        },
        user : {
            lat : null,
            lng : null
        },
        user_location : {},
        form : {
            number : '',
                location: {
                address : ''
            },
            key: 8
        }


    }),
    components : {
        LocationSelector
    },
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
            this.$admin.get('/dashboard-stats').then(({data}) => {
                this.statistics_totals = {
                    households : data.households,
                    four_p_members : data.four_p_members,
                    residents : data.residents,
                    seniors : data.seniors,
                },
                this.gender_series= data.gender_series
                this.vaccinated_series= data.vaccinated_series
                this.civil_status_series= data.civil_status_series
            })
            this.$admin.get('/profile').then(({data}) =>{
                this.user = data
                this.user_location = {
                    lat : data.lat,
                    lng : data.long
                }
            })
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