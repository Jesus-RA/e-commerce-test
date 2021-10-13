export default{
    // name: 'guest',
    component: () => import('../../guest/layouts/GuestLayout.vue'),
    children: [
        {
            path: '',
            name: 'products',
            component: () => import('../pages/Products.vue')
        },
        {
            path: 'checkout',
            name: 'checkout',
            component: () => import('../../guest/pages/Checkout.vue')
        },
        {
            path: 'login',
            name: 'login',
            component: () => import('../../guest/pages/Login.vue')
        },
        {
            path: ':slug',
            name: 'product-details',
            component: () => import('../pages/ProductDetails.vue'),
            props: (route) => ({
                slug: route.params.slug
            })
        },
    ]
}