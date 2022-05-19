<template>
    <div>
        <v-card>
            <v-card-title>
                <v-flex>
                    <span>Households</span> 
                    <v-btn
                        class="mx-2"
                        fab
                        dark
                        color="primary"
                        small
                        @click="addition_edition_dailog = true"
                    >
                        <v-icon >
                            mdi-plus
                        </v-icon>
                    </v-btn>
                </v-flex>
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
            ></v-text-field>
            </v-card-title>
            <v-data-table
            :headers="headers"
            :items="households"
            :search="search"
            >
                <template v-slot:item.residents="{ item }">
                    {{item.residents.length}}
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        class="mx-2"
                        fab
                        dark
                        color="success"
                        small
                        @click="$router.push('household/'+item.id)"
                    >
                        <v-icon >
                            mdi-eye
                        </v-icon>
                    </v-btn>
                    <!-- <v-btn
                        class="mx-2"
                        fab
                        dark
                        color="warning"
                        small
                    >
                        <v-icon >
                            mdi-pencil
                        </v-icon>
                    </v-btn> -->
                    <v-btn
                        class="mx-2"
                        fab
                        dark
                        color="error"
                        small
                        @click="deleteHousehold(item)"
                    >
                        <v-icon >
                            mdi-delete
                        </v-icon>
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>

        <HouseholdForm
            ref="householdForm"
            :form="household"
            :user_location="user_location"
            :dialogState="addition_edition_dailog"
            @close="(addition_edition_dailog = false), initialize()"
            @save="(addition_edition_dailog = false), saveHousehold()"
        />
    </div>
</template>
<script>
import HouseholdForm from '../../components/HouseholdForm.vue'
  export default {
    components: {
        HouseholdForm
    },
    data () {
      return {
        household : {
            number : '',
            location: {
                address : ''
            },
            key: 3
        },
        user : {
            lat : null,
            lng : null
        },
        user_location : {},
        addition_edition_dailog : false,
        search: '',
        headers: [
          { text: 'Number', value: 'number' },
          { text: 'Address', value: 'address' },
          { text: '# of residents', value: 'residents' },
          { text: 'Actions', value: 'actions' },
        ],
        households: [],
      }
    },
    mounted () {
        this.initialize()
    },
    methods : {
        initialize() {
            this.$admin.get('/household/index').then(({data}) =>{
                this.households = data
            })

            this.$admin.get('/profile').then(({data}) =>{
                this.user = data
                this.user_location = {
                    lat : data.lat,
                    lng : data.long
                }
            })
            this.$refs.householdForm.refreshMarkers()

        },
        saveHousehold() {
            this.$admin.post('/household/create',this.household).then(({data}) => {
                this.initialize()
                this.household = {
                    number : '',
                    location: {
                        address : ''
                    },
                    key: 3
                }
                this.successNotify("Household added ")

            })
        },
        async deleteHousehold(household){
            let confirm = await this.deleteRecord("Household: "+household.number +" and residents");
            if (!confirm) return;

            this.$admin.delete(`household/delete/${household.id}`).then(({data}) => {
                this.initialize()
                this.successNotify("Household deleted ")

            })
        }

    }
  }
</script>