import authModule from '../../auth/router'
import productModule from '../../product/router'
import isNotAuthenticatedGuard from './guest-guard'

export default{
    beforeEnter: isNotAuthenticatedGuard,
    component: () => import('../layouts/GuestLayout.vue'),
    children: [
        {
            path: 'checkout',
            name: 'checkout',
            component: () => import('../pages/Checkout.vue')
        },
        ...authModule,
        ...productModule,
    ]
}