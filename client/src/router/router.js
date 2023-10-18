import Products from "@/components/Products";
import {createRouter, createWebHistory} from "vue-router";
import Index from "@/components/Index";
import ProductDetails from "@/components/ProductDetails";
import NotFound from "@/components/NotFound";


const routes = [

    {
        path: '/',
        component: Index
    },
    {
        path: '/products/:categoryId',
        name: 'products',
        component: Products,
        props:true
    },
    {
        path: '/product-details/:goodsId',
        name: 'product-details',
        component: ProductDetails,
        props: true
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: NotFound
    },

]


const router = createRouter({
    routes,
    history: createWebHistory()

})

export default router