<template>
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
                @click="downloadEx"
            >
                <v-icon >
                    mdi-download
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
      :items="residents"
      :search="search"
    >
        <template v-slot:item.household_number="{ item }">
            {{item.household.number}}
        </template>
        <template v-slot:item.address="{ item }">
            {{item.household.address}}
        </template>
        <template v-slot:item.actions="{ item }">
            <v-btn
                class="mx-2"
                fab
                dark
                color="success"
                small
                @click="openResidentDetials(item)"
            >
                <v-icon >
                    mdi-eye
                </v-icon>
            </v-btn>
        </template>
    </v-data-table>
    <ResidentView
        ref="householdForm"
        :form="selected_resident"
        :household_location="household_location"
        :dialogState="view_dialog"
        @close="(view_dialog = false), initialize()"
    />
  </v-card>
</template>
<script>
import LocationSelector from '../../components/LocationMapSelector.vue'
import ResidentView from '../../components/ResidentView.vue'

export default {
    components : {
        LocationSelector,
        ResidentView
        
    },
    data () {
      return {
        search: '',
        headers: [
          { text: 'Full name', value: 'full_name' },
          { text: 'Household number', value: 'household_number' },
          { text: 'Household status', value: 'household_status' },
          { text: 'Addresss', value: 'address' },
          { text: 'Civil Status', value: 'civil_status' },
          { text: 'Contact_number', value: 'contact_number' },
          { text: 'Actions', value: 'actions' },
        ],
        household_location : {
            lat: 12.067878,
            lng: 124.595390
        },
        residents : [],
        selected_resident : {},
        view_dialog:false
      }
    },
    created () {
        this.initialize()
    },
     methods : {
        initialize() {
            this.$admin.get('/residents').then(({data}) =>{
                this.residents = data
            })
        },
        openResidentDetials(item) {
            console.log(item,'sss')
            this.selected_resident = item
            this.household_location = {
                lat: item.household.lat,
                lng: item.household.long
            }
            this.view_dialog = true;
        },
        downloadEx() {
              this.$admin.get('residents/download',{
                responseType: 'arraybuffer'
            })
            .then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'residents.xlsx');
                document.body.appendChild(link);
                link.click();
            })
        }

    }
  }
</script>