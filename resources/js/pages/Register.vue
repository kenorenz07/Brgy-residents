<template>
    <div>
        <v-app id="inspire">
            <v-main>
                <v-container
                    fluid
                    fill-height
                >
                    <v-layout
                    align-center
                    justify-center
                    >
                    <v-flex
                        xs12
                        sm8
                    >
                        <v-card class="elevation-12">
                            <v-toolbar
                                color="light-green"
                                dark
                                flat
                            >
                                <v-toolbar-title>Create new Account (* = required field)</v-toolbar-title>
                            
                            </v-toolbar>
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
                                                label="Name*"
                                                name="name"
                                                prepend-icon="person"
                                                type="text"
                                            ></v-text-field>

                                            <v-text-field
                                                v-model="form.email"
                                                label="Email*"
                                                name="email"
                                                prepend-icon="person"
                                                type="email"
                                            ></v-text-field>

                                            <v-text-field
                                                v-model="form.password"
                                                id="password"
                                                label="Password*"
                                                name="password"
                                                prepend-icon="lock"
                                                :type="show_pass ? 'text' : 'password'"
                                                :append-icon="show_pass ? 'mdi-eye' : 'mdi-eye-off'"
                                                @click:append="show_pass = !show_pass"
                                            ></v-text-field>

                                            <v-text-field
                                                v-model="form.password_confirmation"
                                                id="confirm_password"
                                                label="Confirm password*"
                                                name="confirm_password"
                                                prepend-icon="lock"
                                                :type="show_confirm_password ? 'text' : 'password'"
                                                :append-icon="show_confirm_password ? 'mdi-eye' : 'mdi-eye-off'"
                                                @click:append="show_confirm_password = !show_confirm_password"
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
                                                <LocationSelector v-model="form.location" :key="form.key" />
                                            </div>
                                        </v-sheet>
                                    </v-col>
                                </v-row>

                            </v-card-text>
                            <v-card-actions >
                                <v-spacer></v-spacer>
                                <v-btn @click="$router.push('/login')">Back</v-btn>
                                <v-btn color="primary" @click="register()">Sign up</v-btn>
                            </v-card-actions>
                        </v-card>
                       
                    </v-flex>
                    </v-layout>
                </v-container>
            </v-main>
        </v-app>
    </div>
</template>
<script>
import LocationSelector from './../components/LocationMapSelector.vue'
export default {
    components : {
        LocationSelector
    },
    data: () => ({
        show_pass: false,
        show_confirm_password: false,
        form: {
            name: '',
            email: '',
            password: null,
            password_confirmation: null,
            location: {
                address : ''
            },
            key: 1
        }
    
    }),
    methods : {
        register(){
            this.$admin.post('/register',this.form).then(({data}) => {
                this.successNotify("Registered ")
                this.$router.push('/login')
            })
        },
        reset() {
            this.key += 1;
            this.location = {};
        }
    },

}
</script>