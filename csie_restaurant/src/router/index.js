import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

import MainLayout from '../views/layouts/MainLayout.vue'

const routes = [
    {
        path: '/',
        redirect: '/home/index'
    },
    {
        path: '/home',
        name: 'mainLayout',
        component: MainLayout,
        children: [
            {
                path: 'index',
                component: Home
            },
            {
                path: 'login',
                components: {
                    // 上面的另外一种写法，这样可以在一个组建中嵌入多个路由(router-view)
                    default: () => import('../views/Login.vue')
                },
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
    routes
})

export default router