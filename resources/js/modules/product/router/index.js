export default [
    {
        path: '',
        name: 'products',
        component: () => import('../pages/Products.vue')
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