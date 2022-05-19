<template>
  <v-row justify="center">
    <v-dialog
      v-model="modalState"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?"Edit":"Add"}} Resident (* = required field)</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col      
                    cols="6"
                    md="6"
                    sm="12"
                >
                    <v-text-field
                        v-model="form.first_name"
                        label="First name*"
                        name="first_name"
                        type="text"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.middle_name"
                        label="Middle name*"
                        name="middle_name"
                        type="text"
                    ></v-text-field>
                     <v-text-field
                        v-model="form.last_name"
                        label="Last name*"
                        name="last_name"
                        type="text"
                    ></v-text-field>
                     <v-text-field
                        v-model="form.suffix"
                        label="Suffix"
                        name="suffix"
                        type="text"
                    ></v-text-field>
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="form.birthday"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="form.birthday"
                            label="Pick birthdate*"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="form.birthday"
                            no-title
                            scrollable
                        >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                            @click="menu = false"
                        >
                            Cancel
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$refs.menu.save(form.birthday)"
                        >
                            OK
                        </v-btn>
                        </v-date-picker>
                    </v-menu>
                     <v-text-field
                        v-model="form.age"
                        label="Age*"
                        name="age"
                        type="number"
                    ></v-text-field>
                    <v-select
                        v-model="form.civil_status"
                        :items="civil_statuses"
                        label="Civil status*"
                    ></v-select>
                    <v-select
                        v-model="form.household_status"
                        :items="household_statuses"
                        label="Household status*"
                    ></v-select>
                </v-col>
                <v-col      
                    cols="6"
                    md="6"
                    sm="12"
                >
                    <v-text-field
                        v-model="form.contact_number"
                        label="Contact number*"
                        name="contact_number"
                        type="text"
                    ></v-text-field>
                    <v-select
                        v-model="form.gender"
                        :items="genders"
                        label="Gender*"
                    ></v-select>
                    <v-text-field
                        v-model="form.purok"
                        label="Purok*"
                        name="purok"
                        type="text"
                    ></v-text-field>
                    <v-checkbox
                        v-model="form.vaccinated"
                        label="Vaccinated"
                    ></v-checkbox>
                    <v-text-field
                        v-if="form.vaccinated"
                        v-model="form.vaccine_name"
                        label="Vaccine name"
                        name="vaccine_name"
                        type="text"
                    ></v-text-field>
                    <v-select
                        v-if="form.vaccinated"
                        v-model="form.dose"
                        :items="doses"
                        label="Dose"
                    ></v-select>
                    <v-checkbox
                        v-model="form.is_four_pis_member"
                        label="4ps member"
                    ></v-checkbox>
                     <v-checkbox
                        v-model="form.is_senior_member"
                        label="Senior"
                    ></v-checkbox>
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
          <v-btn
            color="blue darken-1"
            text
            @click="$emit('save')"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
    components : {
    },
    props: {
        dialogState: {
            type: Boolean,
            required: true
        },
        form: {
            type: Object,
            default: {
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
            }
        },

    },
    data: () => ({
        menu: false,
        civil_statuses : ["married", "single", "divorced", "widowed","separated"],
        genders : ["Male", "Female"],
        doses : ["1st dose","2nd Dose","Booster"],
        household_statuses : ["Leader", "Member"]
    }),
    computed : {
      modalState(){
        return this.dialogState
      }
    },
    watch : {
        'form.vaccinated' : {
            deep :true,
            handler(val) {
                if(!val) {
                    this.form.vaccine_name = ""
                    this.form.dose = ""
                }
            }
        }
    }
}
</script>
