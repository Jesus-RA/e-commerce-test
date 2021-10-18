import axios from "axios"

export const getProductsFromLocalStorage = async ({ commit }) => {

    const cart = JSON.parse( localStorage.getItem('cart') )

    commit('setProducts', cart)

}

export const storeOrder = async ({ commit }, order) => {

    await axios.post('/orders', order).catch(({ response }) => response)

    commit('deleteAllProducts')

    return true

}