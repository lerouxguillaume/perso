import ListNasaImages from "./components/Nasa/ListNasaImages";
import Profil from "./components/Profil";
import Home from "./components/Home";
import NasaImageDetail from "./components/Nasa/NasaImageDetail";
import Trade from "./components/Trading/Trade";
import NotFound from "./pages/NotFound";
import TradeList from "./components/Trading/TradeList";
import Vue from 'vue'
import VueRouter from "vue-router";
import {TokenService} from "./services/storage.service";
import Login from "./components/Security/Login";
import axios from 'axios';

Vue.use(VueRouter);

const router =  new VueRouter({
    routes: [
        {
            path: '/',
            name: 'homepage',
            component: Home,
            meta: {
                public: true,  // Allow access to even if not logged in
                breadcumb: [
                    {
                        text: 'Home',
                        active: true
                    }
                ]
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                public: true,  // Allow access to even if not logged in
                onlyWhenLoggedOut: true
            }
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profil,
            meta: {
                public: true,  // Allow access to even if not logged in
                breadcumb: [
                    {
                        text: 'Home',
                        to: {name: 'homepage'}
                    },
                    {
                        text: 'Profile',
                        active: true
                    }
                ]
            }
        },
        {
            path: '/trading',
            name: 'trading_list',
            component: TradeList,
            meta: {
                breadcumb: [
                    {
                        text: 'Home',
                        to: {name: 'homepage'}
                    },
                    {
                        text: 'companies',
                        active: true
                    }
                ]
            }
        },
        {
            path: '/trading/:company',
            name: 'trading_detail',
            component: Trade,
            meta: {
                breadcumb: [
                    {
                        text: 'Home',
                        to: {name: 'homepage'}
                    },
                    {
                        text: 'companies',
                        to: {name: 'trading_list'}
                    },
                    {
                        text: 'company',
                        active: true
                    }
                ]
            }
        },
        {
            path: '/nasa',
            name: 'nasa_list_image',
            component: ListNasaImages,
            meta: {
                public: true,  // Allow access to even if not logged in
                breadcumb: [
                    {
                        text: 'Home',
                        to: {name: 'homepage'}
                    },
                    {
                        text: 'images',
                        active: true
                    }
                ]
            }
        },
        {
            path: '/nasa/day/:day',
            name: 'nasa_image_detail',
            component: NasaImageDetail,
            meta: {
                public: true,  // Allow access to even if not logged in
                breadcumb: [
                    {
                        text: 'Home',
                        to: {name: 'homepage'}
                    },
                    {
                        text: 'images',
                        to: {name: 'nasa_list_image'}
                    },
                    {
                        text: 'image',
                        active: true
                    }
                ]
            }
        },
        {
            path: '*', name: 'not_found',
            component: NotFound
        },
    ]
});

router.beforeEach((to, from, next) => {
    const isPublic = to.matched.some(record => record.meta.public)
    const onlyWhenLoggedOut = to.matched.some(record => record.meta.onlyWhenLoggedOut)
    const loggedIn = !!TokenService.getToken();

    if (!isPublic && !loggedIn) {
        return next({
            path:'/login',
            query: {redirect: to.fullPath}  // Store the full path to redirect the user to after login
        });
    }

    // Do not allow user to visit login page or register page if they are logged in
    if (loggedIn && onlyWhenLoggedOut) {
        return next('/')
    }

    next();
})


export default router;
