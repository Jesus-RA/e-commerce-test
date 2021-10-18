import axios from "axios"

export const fetchProducts = async ({ commit }) => {

    const { data } = await axios.get('/products')

    const products = data.data.map( ({ id, attributes }) => {
        
        const mappedImages = attributes.images.map( ({ attributes }) => ({ ...attributes }))
        return { id, ...attributes, images: mappedImages }

    })

    commit('setProducts', products)

}

export const fetchProduct = async ({ commit }, id) => {

    const { data } = await axios.get(`/products/${ id }`)
    const { data: productData } = data

    const mappedImages = productData.attributes.images.map( image => ({ url: image.attributes.url }) )

    return {
        id: productData.id,
        ...productData.attributes,
        status: productData.attributes.status == '1' ? true : false,
        images: mappedImages,
    }

}

export const storeProduct = async ({ commit, dispatch }, product) => {

    const productData = {
        name: product.name,
        description: product.description,
        price: product.price,
        status: product.status,
        stock: product.stock,
    }

    const response = await axios.post('/products', productData)
        .catch(({response}) => response)

    if( response.status == 409 ) return false

    const { data } = response.data

    let formData =  new FormData()
    formData.append('product_id', data.id)
    for(let image of product.images){
        formData.append('images[]', image)
    }

    await axios.post('/media', formData, {
        headers: {
            'content-type': 'multipart/form-data',
        }
    })

    let newProduct = await dispatch('fetchProduct', data.id )

    commit('addProduct', newProduct)

    return true

}

export const updateProduct = async ({ commit }, product) => {

    const productData = { 
        name: product.name,
        description: product.description,
        price: product.price,
        status: product.status,
        stock: product.stock,
    }
    const response = await axios.put(`/products/${ product.id }`, productData)
    const productUpdated = { id: response.data.data.id, ...response.data.data.attributes }

    if( response.status === 201)
        commit('updateProduct', productUpdated)

}

export const deleteProduct = async ({ commit }, productId) => {

    const response = await axios.delete(`/products/${ productId }`)

    if( response.status === 204 )
        commit('deleteProduct', productId)

}