export const setProducts = ( state, products ) => {
    state.products = [ ...state.products, ...products ]
}

export const addProduct = (state, product) => {
    state.products = [ ...state.products, product ]
}

export const updateProduct = (state, product) => {
    
    const products = state.products.map( p => {

        if( p.id === product.id )
            return { ...product }

        return { ...p }

    })

    state.products = products

}

export const deleteProduct = (state, productId) => {

    const products = state.products.filter( product => product.id != productId)

    state.products = [ ...products ]

}

export const setSelectedProductId = (state, productId) => state.selectedProductId = productId