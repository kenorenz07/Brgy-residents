<template>
  <v-row justify="center">
    <v-dialog
      v-model="modalState"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">Add Household (* = required field)</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col      
                    cols="12"
                    sm="12"
                    md="12"
                >
                  <v-form
                    ref="form"
                    lazy-validation
                  >
                    <v-sheet max-width="100%" width="100%">
                        <v-flex>
                            <span>Double click to select location or Search</span>
                        </v-flex>
                        <div style="width:100%;height: 500px">
                            <LocationSelector ref="locationSelector" v-model="form.location" :key="form.key" :household_location="user_location" />
                        </div>
                    </v-sheet>
                    <v-text-field
                        v-model="form.number"
                        label="Number*"
                        name="number"
                        prepend-icon="home"
                        type="text"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.location.address"
                        label="Address"
                        name="address"
                        prepend-icon="map"
                        type="text"
                        :disabled="true"
                    ></v-text-field>
                  </v-form>
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
            default: {
                number : '',
                location: {
                    address : ''
                },
                key: 3
            }
        },
        user_location : {
            type: Object,
            default :{
              lat: 12.067878,
              lng: 124.595390
            }
        }
    },
    data: () => ({
    
    }),
    methods : {
      refreshMarkers() {
        this.$refs.locationSelector.getMarkers()
      }
    },
    computed : {
      modalState(){
        return this.dialogState
      }
    }
}
</script>
