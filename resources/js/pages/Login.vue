<template>
    <div>
        <v-app id="inspire">
            <v-content>
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
                        md4
                    >
                        <v-card class="elevation-12">
                        <v-toolbar
                            color="light-green"
                            dark
                            flat
                        >
                            <v-toolbar-title>GIS Based Barangay Records</v-toolbar-title>
                           
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-text-field
                                    v-model="form.email"
                                    label="Login"
                                    name="login"
                                    prepend-icon="person"
                                    type="text"
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
                            </v-form>
                        </v-card-text>
                        <v-card-actions >
                            <v-spacer></v-spacer>
                            <v-btn color="warning" @click="$router.push('/register')">Create new Account</v-btn>
                            <v-btn @click="login_admin()">Login</v-btn>
                        </v-card-actions>
                        </v-card>
                    </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
        </v-app>
    </div>
</template>
<script>
export default {
    data: () => ({
        show_pass: false,
        form: {
            email: '',
            password:null,
        }
    }),
    methods : {
        login_admin(){
            
                axios.post('/api/login',this.form).then(({data}) => {
                    console.log(data)
                    if(data.error) {
                        this.errorNotify("Username or password are incorrect")
                    }
                    else{
                        localStorage.setItem('token',data.token)
                        this.$router.push('/dashboard')
                    }
                })

        }
    }
}
</script>