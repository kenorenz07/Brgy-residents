<template>
  <v-navigation-drawer
        app
        v-model="mini"
        persistent
    >
        <v-list-item class="px-2 pt-2">
            <strong>{{user.address}}</strong>
        </v-list-item>
        <v-list >
            <v-list-item
                v-for="item in items"
                :key="item.title"
                color="secondary"
                :class="{
                    'v-list-item--active': checkIfActive(item.route)
                }"
                @click.stop="$router.push(item.route)"
            >
                <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        <template v-slot:append>
            <v-list-item
                color="secondary"
                @click.stop="logoutAdmin"
            >
                <v-list-item-icon>
                    <v-icon>mdi-logout-variant</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Log-out</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-navigation-drawer>
</template>
<script>
export default {
    data: () => ({
        drawer: true,
        items: [
            { title: 'My account', icon: 'mdi-account', route: '/account' },
            { title: 'Dashboard', icon: 'mdi-view-dashboard', route: '/dashboard' },
            { title: 'Households', icon: 'mdi-home-city', route: '/households' },
        ],
        user : { address : ''},
    }),
    props : {
        mini : {
            require: true,
            type : Boolean
        }
    },
    mounted () {
        this.getUser()
    },
    computed : {
        activeRoute () {
            return this.$route
        },
        mini_status: {
            get: function() {
                return this.mini
            },
            set: function(value) {
                console.log(value,"status")
                this.$emit('changeStatusDrawer')
            }
        }
    },
    methods : {
        logoutAdmin(){
            this.$admin.post('/logout').then((response) => {
                localStorage.removeItem("token")
                this.$router.push('/login')
            })
        },
        getUser(){
            this.$admin.get('/profile').then(({data}) =>{
                this.user = data
            })
        },
        checkIfActive(route){
            let route_text = route.split("/")
            return route_text[1].includes(this.activeRoute.name)
        }
    },
    
}
</script>