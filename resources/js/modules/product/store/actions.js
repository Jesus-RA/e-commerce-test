import axios from "axios"

export const fetchProducts = async ({ commit }) => {

    const { data } = await axios.get('/products')

    const products = data.data.map( ({ id, attributes }) => {
        
        const mappedImages = attributes.images.map( ({ attributes }) => ({ ...attributes }))
        return { id, ...attributes, images: mappedImages }

    })

    commit('setProducts', products)

}