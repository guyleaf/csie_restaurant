import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: () => import('@/views/layouts/MainLayout.vue'),
        meta: {
            title: '孜宮庭園',
        },
        children: [
            {
                name: 'Home',
                path: '',
                component: () => import('@/views/Home.vue'),
                meta: {
                    title: '孜宮庭園 - 首頁',
                }
            },
            {
                name: 'Login',
                path: 'login',
                component: () => import('@/views/Login.vue'),
                meta: {
                    title: '孜宮庭園 - 登入',
                }
            },
            {
                name: 'Shop',
                path: 'shop',
                component: () => import('@/views/Shop.vue'),
                meta: {
                    title: '孜宮庭園 - 商店',
                }
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
    mode: 'hash',
    routes: routes
})

export default router