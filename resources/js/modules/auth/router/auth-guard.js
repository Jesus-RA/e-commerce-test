import store from '../../../store'

const isAuthenticatedGuard = async (to, from, next) => {

    const isAuthenticated = await store.dispatch('checkAuthentication')

    if( isAuthenticated ) next()
    else next({ name: 'login' })

}

export default isAuthenticatedGuard