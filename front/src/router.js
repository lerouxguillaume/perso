import ListNasaImages from "./pages/Nasa/ListNasaImages";
import Profil from "./pages/Profil";
import Home from "./pages/Home";
import NasaImageDetail from "./pages/Nasa/NasaImageDetail";
import NotFound from "./pages/NotFound";
import Vue from 'vue'
import VueRouter from "vue-router";
import {TokenService} from "./services/storage.service";
import Login from "./pages/Security/Login";
import VideoList from "./pages/Video/VideoList";
import Serie from "./pages/Video/Serie";
import Movie from "./pages/Video/Movie";

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
            path: '/video',
            name: 'video_list',
            component: VideoList,
            meta: {
                public: true,  // Allow access to even if not logged in
                breadcumb: [
                    {
                        text: 'Home',
                        to: {name: 'homepage'}
                    },
                    {
                        text: 'Videos',
                        active: true
                    }
                ]
            }
        },
        {
            path: '/serie/:id',
            name: 'serie',
            component: Serie,
            meta: {
                public: true,  // Allow access to even if not logged in
                breadcumb: [
                    {
                        text: 'Home',
                        to: {name: 'homepage'}
                    },
                    {
                        text: 'Videos',
                        to: {name: 'video_list'}
                    },
                    {
                        text: 'serie',
                        active: true
                    }
                ]
            }
        },
        {
            path: '/movie/:id',
            name: 'movie',
            component: Movie,
            meta: {
                public: true,  // Allow access to even if not logged in
                breadcumb: [
                    {
                        text: 'Home',
                        to: {name: 'homepage'}
                    },
                    {
                        text: 'Videos',
                        to: {name: 'video_list'}
                    },
                    {
                        text: 'movie',
                        active: true
                    }
                ]
            }
        },
        {
            path: '/nasa/list/:page?',
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
