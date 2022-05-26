<template>
    <div>
        <v-card>
            
          <v-container>
            <v-row>
                <v-col      
                    cols="8"
                    sm="8"
                    md="8"
                >
                    <v-sheet max-width="100%" width="100%">
                        <v-flex>
                            <span>Double click to select location or Search</span>
                        </v-flex>
                        <div style="width:100%;height: 300px">
                            <LocationSelector ref="locationSelector" v-model="household.location" :key="household.key" :household_location="household_location" :household_id="household_data.id" />
                        </div>
                    </v-sheet>
                </v-col>
                <v-col
                    cols="4"
                    sm="4"
                    md="4"
                >

                    <v-form
                        ref="form"
                        lazy-validation
                    >
                        <v-text-field
                            v-model="household.number"
                            label="Number"
                            name="number"
                            prepend-icon="home"
                            type="text"
                        ></v-text-field>
                        <v-text-field
                            v-model="household.address"
                            label="Address"
                            name="address"
                            prepend-icon="map"
                            type="text"
                        ></v-text-field>
                         <v-text-field
                            v-if="household.location.position.lat != 0"
                            v-model="household.location.position.lat"
                            label="Latitude"
                            name="latitude"
                            prepend-icon="map"
                            type="number"
                        ></v-text-field>
                            <v-text-field
                            v-if="household.location.position.lng != 0"
                            v-model="household.location.position.lng"
                            label="Longitude"
                            name="longitude"
                            prepend-icon="map"
                            type="number"
                        ></v-text-field>

                        <v-btn color="primary" @click="saveHousehold">Update</v-btn>
                    </v-form>
                </v-col>
            </v-row>
            <v-row>
                <v-col    
                    cols="12"
                    sm="12"
                    md="12"
                >
                    <v-card>
                        <v-card-title>
                            <v-flex>
                                <span>Residents</span> 
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
                        :items="household_data.residents"
                        :search="search"
                        >
                            <template v-slot:item.vaccinated="{ item }">
                                {{item.vaccinated ? "Yes" : "No"}}
                            </template>
                             <template v-slot:item.is_four="{ item }">
                                {{item.is_four_pis_member ? "Yes" : "No"}}
                            </template>
                             <template v-slot:item.is_senior_member="{ item }">
                                {{item.is_senior_member ? "Yes" : "No"}}
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <!-- <v-btn
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
                                </v-btn> -->
                                 <v-btn
                                    class="mx-2"
                                    fab
                                    dark
                                    color="warning"
                                    @click="editResident(item)"
                                    small
                                >
                                    <v-icon >
                                        mdi-pencil
                                    </v-icon>
                                </v-btn> 
                                <v-btn
                                    class="mx-2"
                                    fab
                                    dark
                                    color="error"
                                    small
                                    @click="deleteResident(item)"
                                >
                                    <v-icon >
                                        mdi-delete
                                    </v-icon>
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-card>    
                </v-col>
            </v-row>
          </v-container>
        </v-card>
        <ResidentForm
            :form="resident"
            :dialogState="addition_edition_dailog"
            @close="(addition_edition_dailog = false), initialize()"
            @save="(addition_edition_dailog = false), saveResident()"
        />

    </div>
</template>
<script>
import LocationSelector from '../../../components/LocationMapSelector.vue'
import ResidentForm from '../../../components/ResidentForm.vue'
export default {
    components : {
        LocationSelector,
        ResidentForm
    },
    data () {
      return {
        household : {
            number : '',
            address : '',
            location: {
                address : '',
                position : {
                    lat : 0,
                    lng : 0
                }
            },
            key: 5
        },
        household_data : {
            number : '',
        },
        resident : {
            id:null,
            household_id : null,
            first_name : '',
            middle_name : '',
            last_name : '',
            suffix : '',
            birthday : (new Date()).toISOString().split('T')[0],
            age : null,
            civil_status : 'single',
            contact_number : '',
            sex : null,
            blood_type : null,
            birth_country : '',
            birth_province : '',
            birth_city : '',
            purok : '',
            vaccinated : false,
            vaccine_name : '',
            dose : '',
            is_four_pis_member : false,
            is_senior_member : false,
        },
        headers: [
          { text: 'Full name', value: 'full_name' },
          { text: 'Birthdate', value: 'birthday' },
          { text: 'Age', value: 'age' },
          { text: 'Civil Status', value: 'civil_status' },
          { text: 'Contact_number', value: 'contact_number' },
          { text: 'Sex', value: 'sex' },
          { text: 'Purok', value: 'purok' },
          { text: 'Vaccinated', value: 'vaccinated' },
          { text: '4ps member', value: 'is_four' },
          { text: 'Senior citizen', value: 'is_senior_member' },
          { text: 'Actions', value: 'actions' },
        ],
        household_location : {
            lat: 12.067878,
            lng: 124.595390
        },
        addition_edition_dailog : false,
        search: '',
        
      }
    },
    created () {
        this.initialize()
        this.resetResident()
    },
    computed : {
    },
    methods : {
        initialize() {
            this.$admin.get('/household/show/'+this.$route.params.id).then(({data}) =>{
                this.household = {
                    number : data.number,
                    address : data.address,
                    location: {
                        position : {
                            lng : data.long,
                            lat : data.lat 
                        },
                    },
                    key: 5
                }
                this.household_data = data
                this.household_location = {
                    lng : data.long,
                    lat : data.lat
                }
            })
        },
        resetResident(){
            this.resident = {
                id:null,
                household_id : this.$route.params.id,
                first_name : '',
                middle_name : '',
                last_name : '',
                suffix : '',
                birthday : (new Date()).toISOString().split('T')[0],
                age : null,
                civil_status : 'single',
                contact_number : '',
                sex : null,
                blood_type : null,
                birth_country : '',
                birth_province : '',
                birth_city : '',
                purok : '',
                vaccinated : false,
                vaccine_name : '',
                dose : '',
                is_four_pis_member : false,
                is_senior_member : false,
            }
        },
        editResident(resident){
            this.resident = resident
            this.addition_edition_dailog = true
        },
        saveResident() {
            var end_point = this.resident.id ? `resident/update/${this.resident.id}` : `/household/${this.household_data.id}/resident`

            this.$admin.post(end_point,this.resident).then(({data}) => {
                this.successNotify(`Resident ${this.resident.id ? "updated" : "added"} `)
                this.resetResident()
                this.initialize()
            })
        },
        async deleteResident(resident) {
            let confirm = await this.deleteRecord("Resident : "+resident.full_name);
            if (!confirm) return;

            this.$admin.delete(`resident/delete/${resident.id}`).then(({data}) => {
                this.successNotify("Resident deleted ")
                this.initialize()
            })
        },
        saveHousehold() {
            this.$admin.put('/household/update/'+this.$route.params.id,this.household).then(({data}) => {
                this.initialize()
                this.successNotify("Household updated ")
            })
        },
        async deleteHousehold(){
            let confirm = await this.deleteRecord("Household: "+this.household.number +" and residents");
            if (!confirm) return;

            this.$admin.delete(`household/delete/${this.household.id}`).then(({data}) => {
                this.successNotify("Household deleted ")
                this.initialize()
            })
        }

    }
  }
</script>

<style scoped>
.vue2leaflet-map {
    z-index: 0;
}
</style>