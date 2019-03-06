import ListNasaImages from "./components/Nasa/ListNasaImages";
import Profil from "./components/Profil";
import Home from "./components/Home";
import NasaImageDetail from "./components/Nasa/NasaImageDetail";
import Trade from "./components/Trading/Trade";
import NotFound from "./pages/NotFound";
import TradeList from "./components/Trading/TradeList";

export default [
    {
        path: '/',
        name: 'homepage',
        component: Home,
        meta: {
            breadcumb: [
                {
                    text: 'Home',
                    active: true
                }
            ]
        }
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profil,
        meta: {
            breadcumb: [
                {
                    text: 'Home',
                    to: { name: 'homepage'}
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
                    to: { name: 'homepage'}
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
                    to: { name: 'homepage'}
                },
                {
                    text: 'companies',
                    to: { name: 'trading_list'}
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
            breadcumb: [
                {
                    text: 'Home',
                    to: { name: 'homepage'}
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
            breadcumb: [
                {
                    text: 'Home',
                    to: { name: 'homepage'}
                },
                {
                    text: 'images',
                    to: { name: 'nasa_list_image'}
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
];