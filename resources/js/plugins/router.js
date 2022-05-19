import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';
import Main from '../pages/Main.vue';
import Account from '../pages/Admin/Account.vue';
import Dashboard from '../pages/Admin/Dashboard.vue';
import Households from '../pages/Admin/Households.vue';
import Household from '../pages/Admin/View/Household.vue';

import Map from '../pages/Map.vue'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active-route',
    routes: [
        {
            path: '',
            name: 'main',
            component: Main,
            meta: {
                requiresAuth: true
            },
            children : [
                {
                    path: '/account',
                    name: 'account',
                    component: Account,
                },
                {
                    path: '/dashboard',
                    name: 'dashboard',
                    component: Dashboard,
                },
                {
                    path: '/households',
                    name: 'households',
                    component: Households,
                },
                {
                    path: '/household/:id',
                    name: 'household',
                    component: Household,
                },
               
            ]
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                requiresAuth: false
            },
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {
                requiresAuth: false
            },
        },
        {
            path: '/map',
            name: 'map',
            component: Map,
            meta: {
                requiresAuth: false
            },
        },
    ]
});

router.beforeEach(async (to, from, next) => {
    localStorage.setItem('from', from.fullPath)

    const user = localStorage.getItem('token')


    console.log(user)
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    
    if (!requiresAuth && user) {
        console.log('not require auth but there is user')
        next(from)
    } else if (requiresAuth && !user) {
        console.log('require auth there is no user')
        next('/login');
    } else {
        console.log('next')
        next();
    }

})

export default router;