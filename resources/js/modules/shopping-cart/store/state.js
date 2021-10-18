export default () => ({
    products: localStorage.getItem('cart') || []    
})