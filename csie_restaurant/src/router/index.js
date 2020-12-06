import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'MainLayout',
        component: () => import('@/views/layouts/MainLayout.vue'),
        children: [
            {
                name: 'Home',
                path: '',
                component: () => import('@/views/Home.vue')
            },
            {
                name: 'Login',
                path: 'login',
                component: () => import('@/views/Login.vue')
            },
            {
                name: 'Shop',
                path: 'shop',
                component: () => import('@/views/Shop.vue')
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