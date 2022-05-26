<template>
    <div>
          <v-card class="elevation-12">
            <v-card-text>
                <v-row>
                    <v-col      
                        cols="6"
                        md="6"
                        sm="12"
                    >
                        <v-form>
                            <v-text-field
                                v-model="form.name"
                                label="Name"
                                name="name"
                                prepend-icon="person"
                                type="text"
                            ></v-text-field>

                            <v-text-field
                                v-model="form.email"
                                label="Email"
                                name="email"
                                prepend-icon="person"
                                type="email"
                            ></v-text-field>

                            <v-text-field
                                v-model="form.password"
                                id="password"
                                label="Password"
                                name="password"
                                prepend-icon="lock"
                                :type="show_pass ? 'text' : 'password'"
                                :append-icon="show_pass ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="show_pass = !show_pass"
                            ></v-text-field>

                            <v-text-field
                                v-model="form.password_confirmation"
                                id="confirm_password"
                                label="Confirm password"
                                name="confirm_password"
                                prepend-icon="lock"
                                :type="show_confirm_password ? 'text' : 'password'"
                                :append-icon="show_confirm_password ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="show_confirm_password = !show_confirm_password"
                            ></v-text-field>

                            <v-text-field
                                v-model="form.address"
                                label="Address"
                                name="address"
                                prepend-icon="map"
                                type="text"
                            ></v-text-field>
                            <v-text-field
                                v-if="form.location.position.lat != 0"
                                v-model="form.location.position.lat"
                                label="Latitude"
                                name="latitude"
                                prepend-icon="map"
                                type="number"
                            ></v-text-field>
                                <v-text-field
                                v-if="form.location.position.lng != 0"
                                v-model="form.location.position.lng"
                                label="Longitude"
                                name="longitude"
                                prepend-icon="map"
                                type="number"
                            ></v-text-field>
                        </v-form>
                    </v-col>
                    <v-col      
                        cols="6"
                        md="6"
                        sm="12"
                    >
                        <v-sheet>
                            <v-flex>
                                <span>Double click to select location or Search</span>
                            </v-flex>
                            <div style="width:100%;height: 500px">
                                <LocationSelector v-model="form.location" :key="form.key" :household_location="user_location" :household_id="form.id" :from_secretary="true" />
                            </div>
                        </v-sheet>
                    </v-col>
                </v-row>

            </v-card-text>
            <v-card-actions >
                <v-btn color="primary" @click="update()">Update</v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>
<script>
import LocationSelector from '../../components/LocationMapSelector.vue'
  export default {
    components: {
        LocationSelector
    },
    data () {
      return {
        show_pass: false,
        show_confirm_password: false,
        form: {
            id:null,
            name: '',
            email: '',
            password: null,
            address : '',
            password_confirmation: null,
            location: {
                address : '',
                position : {
                    lat : 0,
                    lng : 0
                }
            },
            key: 1
        },
        user_location : {},
      }
    },
    mounted () {
        this.initialize()
    },
    methods : {
        initialize() {
            this.$admin.get('/profile').then(({data}) =>{
                this.form.id = data.id
                this.form.name = data.name
                this.form.email = data.email
                this.form.address = data.address
                this.form.location = {
                    address : data.address,
                    position : {
                        lat : data.lat,
                        lng : data.long
                    }
                }
                this.user_location = {
                    lat : data.lat,
                    lng : data.long
                }

            })

        },
        update() {
            this.$admin.put(`update/${this.form.id}`,this.form).then(({data}) => {
                this.initialize()
                this.form.password=  null
                this.form.password_confirmation= null
            })
        }
    }
  }
</script>