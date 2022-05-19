<template>
  <v-row justify="center">
    <v-dialog
      v-model="modalState"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col      
                    cols="12"
                    sm="12"
                    md="12"
                >
                    <v-sheet max-width="100%" width="100%">
                        <v-flex>
                            <span>(The pin in the center is the household where the resident stay)</span>
                        </v-flex>
                        <div style="width:100%;height: 360px">
                            <LocationSelector v-model="location" :key="key" :household_location="household_location" :marker_select="false" />
                        </div>
                    </v-sheet>
                    <v-row class="mt-2">
                        <v-col cols=6>
                            <p><strong>Household number </strong>: {{form.household ? form.household.number : ''}}</p>
                            <p><strong>Household status </strong>: {{form.household_status}}</p>
                            <p><strong>Full name </strong>: {{form.full_name}}</p>
                            <p><strong>Birthdate </strong>: {{form.birthday}}</p>
                            <p><strong>Age </strong>: {{form.age}} year/s old</p>
                            <p><strong>Civil status </strong>: {{form.civil_status}}</p>
                            <p><strong>Contact number </strong>: {{form.contact_number}}</p>
                          
                        </v-col>
                        <v-col cols=6>
                            <p><strong>Gender</strong> : {{form.gender}}</p>
                            <p><strong>Purok</strong> : {{form.purok}}</p>
                            <p v-if="form.vaccinated"><strong>Vaccinated</strong></p>
                            <p v-if="form.vaccinated"><strong>Vaccine name </strong>: {{form.vaccine_name}}</p>
                            <p v-if="form.vaccinated"><strong>Dose </strong>: {{form.dose}}</p>
                            <p v-if="form.is_four_pis_member"><strong>4ps member</strong></p>
                            <p v-if="form.is_senior_member"><strong>Senior</strong></p>
                        </v-col>
                    </v-row>
                    
                </v-col>
            </v-row>
          </v-container>
       
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="$emit('close')"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import LocationSelector from './../components/LocationMapSelector.vue'
export default {
    components : {
        LocationSelector
    },
    props: {
        dialogState: {
            type: Boolean,
            required: true
        },
        form: {
            type: Object,
            default : {
                id:null,
                household_id : null,
                household_status : null,
                first_name : '',
                middle_name : '',
                last_name : '',
                suffix : '',
                birthday : (new Date()).toISOString().split('T')[0],
                age : null,
                civil_status : 'single',
                contact_number : '',
                gender : null,
                purok : '',
                vaccinated : false,
                vaccine_name : '',
                dose : '',
                is_four_pis_member : false,
                is_senior_member : false,
                household : {
                    number : null,
                    address :null
                }
            }
        },
        household_location : {
            type: Object,
            default :{
              lat: 12.067878,
              lng: 124.595390
            }
        }
    },
    data: () => ({
        key : 23,
        location: {
            address : ''
        },
    }),
    methods : {
    },
    computed : {
      modalState(){
        return this.dialogState
      }
    }
}
</script>
