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
                            <v-toolbar-title>Create new Account</v-toolbar-title>
                           
                        </v-toolbar>
                        <v-card-text>
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

                                <v-text-field
                                    v-model="form.password_confirmation"
                                    id="confirm_password"
                                    label="confirm_password"
                                    name="confirm_password"
                                    prepend-icon="lock"
                                    :type="show_confirm_password ? 'text' : 'password'"
                                    :append-icon="show_confirm_password ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="show_confirm_password = !show_confirm_password"
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions >
                            <v-spacer></v-spacer>
                            <v-btn @click="register()">Sign up</v-btn>
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
        show_confirm_password: false,
        form: {
            name: '',
            email: '',
            password: null,
            password_confirmation: null,
        }
    }),
    methods : {
        register(){
            this.$admin.post('/register',this.form).then(({data}) => {
                this.successNotify("Registered ")
            })
        }
    }
}
</script>