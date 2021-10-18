export const setProducts = (state, products) => {
    state.products = [ ...products ]
}

export const addProduct = ( state, product ) => {

    const isProductInCart = state.products.find( p => p.id === product.id )

    if( !isProductInCart ){
        state.products = [ ...state.products, product ]
    }

    const products = state.products.map( p => {

        if( p.id === product.id )
            return { ...product, quantity: p.quantity + product.quantity }

        return { ...p }

    })

    state.products = products

    localStorage.setItem('cart', JSON.stringify(state.products))
}

export const deleteProduct = ( state, productId ) => {

    const products = state.products.filter( p => p.id !== productId )
    state.products = products
    localStorage.setItem('cart', JSON.stringify(state.products))

}

export const updateProduct = ( state, product ) => {

    const products = state.products.map( p => {

        if( p.id === product.id )
            return { ...product }

        return { ...p }

    })

    state.products = products
    localStorage.setItem('cart', JSON.stringify(state.products))

}

export const deleteAllProducts = ( state ) => {
    state.products = []
    localStorage.setItem('cart', JSON.stringify([]))
}