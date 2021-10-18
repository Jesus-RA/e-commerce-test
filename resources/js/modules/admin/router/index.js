import isAuthenticatedGuard from '../../auth/router/auth-guard'

export default {
    beforeEnter: isAuthenticatedGuard,
    component: () => import('../layouts/AdminLayout.vue'),
    children: [
        {
            path: 'users',
            name: 'admin-users',
            component: () => import('../pages/UsersPage.vue'),
        },
        {
            path: 'products',
            name: 'admin-products',
            component: () => import('../pages/ProductsPage.vue')
        },
        {
            path: 'products/:slug',
            name: 'admin-product-details',
            component: () => import('../pages/ProductDetails.vue'),
            props: (route) => ({ slug: route.params.slug })
        }
    ]
}