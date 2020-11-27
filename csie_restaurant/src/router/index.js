import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '@/views/Home.vue'

Vue.use(VueRouter)

import MainLayout from '@/views/layouts/MainLayout.vue'

const routes = [
    {
        path: '/',
        name: 'MainLayout',
        component: MainLayout,
        children: [
            {
                name: 'Home',
                path: '',
                component: Home
            },
            {
                name: 'Login',
                path: 'login',
                component: () => import('@/views/Login.vue')
            },
        ]
    }

    // {
    //     path: '/login',
    //     name: 'login',
    //     // route level code-splitting
    //     // this generates a separate chunk (login.[hash].js) for this route
    //     // which is lazy-loaded when the route is visited.
    //     component: () => import(/* webpackChunkName: "login" */ '../views/:Login.vue')
    // }
]

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

export default router