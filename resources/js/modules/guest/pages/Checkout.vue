<template>
    <div class="container my-5">
        <h1>Cart details</h1>

        <div v-if="getProducts.length > 0" class="row mt-4">
            <div
                class="col-11 mx-auto border-bottom border-top-0 border-left-0 border-right-0"
                v-for="product in getProducts"
                :key="product.id"
            >
                <ProductCartCard :product="product" />
            </div>
            <div class="col-11 mx-auto mt-4">
                <div class="row justify-content-between">
                    <b>Total: {{ this.formatter.format(total) }}</b>
                    <CheckoutForm />
                </div>
            </div>
        </div>

        <div v-else>
            <b-alert
                show
                variant="info"
                class="text-center"
            >
                There are no products in your shopping cart
            </b-alert>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import CurrencyFormatter from '../../shopping-cart/helpers/CurrencyFormatter'

export default {
    data(){
        return {
            formatter: CurrencyFormatter
        }
    },
    computed: {
        ...mapGetters('shoppingCartModule', ['getProducts']),
        total(){
            const products = this.getProducts

            return products.reduce( (acc, product) => {

                return acc += Number(product.price) * product.quantity

            }, 0)
        }
    },
    components: {
        ProductCartCard: () => import('../../shopping-cart/components/ProductCartCard.vue'),
        CheckoutForm: () => import('../../shopping-cart/components/CheckoutForm.vue')
    }
}
</script>

<style scoped>
    .col-md-4{
        height: 10rem;
    }

    img{
        height: 100%;
        width: 100%;
    }
</style>