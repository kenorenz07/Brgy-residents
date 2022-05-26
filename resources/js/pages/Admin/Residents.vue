<template>
  <v-card>
    <v-card-title>
        <v-row class="p-2">
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
             <v-switch
                v-model="filter.vaccinated"
              label="Vaccinated"
            ></v-switch>
            <v-switch
                v-model="filter.senior"
              label="Senior"
            ></v-switch>
            <v-switch
                v-model="filter.four_p"
              label="4ps member"
            ></v-switch>
            <v-text-field
                v-model="search_key"
                label="Purok"
                single-line
                hide-details
                class="shrink ml-2"
            ></v-text-field>
        </v-row>
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
          { text: 'Addresss', value: 'address' },
          { text: 'Civil Status', value: 'civil_status' },
          { text: 'Contact_number', value: 'contact_number' },
          { text: 'Actions', value: 'actions' },
        ],
        household_location : {
            lat: 12.067878,
            lng: 124.595390
        },
        filter : {
            senior: false,
            vaccinated: false,
            four_p: false,
        },
        search_key : '',
        residents : [],
        selected_resident : {},
        view_dialog:false
      }
    },
    created () {
        this.initialize()
    },
    watch : {
        'filter' : {
            deep : true, 
            handler (val) {
                this.initialize()
            }
        },
        'search_key' : {
            handler (val) {
                this.initialize()
            }
        }
    },
     methods : {
        initialize() {
            this.$admin.get('/residents',{
                params : {
                    senior: this.filter.senior ? 1 : 0,
                    vaccinated: this.filter.vaccinated ? 1 : 0,
                    four_p: this.filter.four_p ? 1 : 0,
                    search_key : this.search_key
                }
            }).then(({data}) =>{
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
                responseType: 'arraybuffer',
                params : {
                    senior: this.filter.senior ? 1 : 0,
                    vaccinated: this.filter.vaccinated ? 1 : 0,
                    four_p: this.filter.four_p ? 1 : 0,
                    search_key : this.search_key
                }
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