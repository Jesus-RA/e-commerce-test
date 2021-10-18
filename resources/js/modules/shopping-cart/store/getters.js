export const getProducts = ( state ) => {
    return state.products
}

export const getProductById = ( { products }) => ( id ) => {

    return products.find( product => product.id === id )

}