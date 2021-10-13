export const setProducts = ( state, products ) => {
    state.products = [ ...state.products, ...products ]
}