import store from '../../../store'

const isNotAuthenticatedGuard = async (to, from, next) => {
    const isAuthenticated = await store.dispatch('checkAuthentication')

    if( !isAuthenticated ) next()
    else next({ name: 'admin-users' })
}

export default isNotAuthenticatedGuard