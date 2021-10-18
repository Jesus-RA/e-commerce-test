export const getProducts = (state) => {
    return state.products
}

export const getProductBySlug = (state) => (slug) => {
    return state.products.find( product => product.slug == slug )
}

export const getSelectedProductId = (state) => {
    return state.selectedProductId
}