import Vue from 'vue'
import VueRouter from 'vue-router';

import guestRouter from '../modules/guest/router'
import adminRouter from '../modules/admin/router'

import isAuthenticatedGuard from '../modules/auth/router/auth-guard'
import isNotAuthenticatedGuard from '../modules/guest/router/guest-guard'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        ...guestRouter,
    },
    {
        path: '/admin',
        ...adminRouter,
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router