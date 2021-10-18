<template>
    <div class="container mt-5">

        <button class="btn btn-dark btn-sm mb-4" @click="$router.push({ name: 'products' })">
            Go back
        </button>

        <div class="card shadow-sm p-5 border-0">
            <div class="row align-items-center">
                <div class="col-md-5 p-0">
                    <ImagesCarousel :images="product.images" />
                </div>

                <div class="col ml-md-4">
                    <h3 class="mb-3">{{ product.name }}</h3>

                    <p>
                        {{ product.description }}
                    </p>

                    <b>Price: {{ this.formatter.format(product.price) }}</b>

                    <div class="input-group" v-if="stock">
                        <label class="input-group-text" for="quantity">Quantity:</label>
                        <select class="form-select" id="quantity" v-model="productQuantity">
                            <option
                                v-for="quantity in stock"
                                :key="quantity"
                                :value="quantity"
                            >
                                {{ quantity }}
                            </option>
                        </select>
                    </div>

                    <b-alert
                        v-else
                        show
                        variant="dark"
                        class="text-center"
                    >
                        No stock available
                    </b-alert>

                    <button
                        v-if="stock"
                        class="btn btn-primary btn-sm mt-4"
                        @click="addToCart"
                    >
                        Add to cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
import CurrencyFormatter from '../../shopping-cart/helpers/CurrencyFormatter'

export default {
    props: {
        slug: {
            type: String,
            required: true,
        }
    },
    data(){
        return {
            product: null,
            productQuantity: 1,
            formatter: CurrencyFormatter
        }
    },
    created(){
        this.product = this.getProductBySlug( this.slug )
    },
    methods: {
        ...mapMutations('shoppingCartModule', ['addProduct']),
        addToCart(){

            const product = {
                id: this.product.id,
                name: this.product.name,
                slug: this.product.slug,
                description: this.product.description,
                images: this.product.images,
                price: this.product.price,
                quantity: this.productQuantity
            }

            this.addProduct( product )

            this.$swal({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: `Product ${ this.product.name } added to the cart`
            })

        }
    },
    computed: {
        ...mapGetters('productModule', ['getProductBySlug']),
        ...mapGetters('shoppingCartModule', ['getProductById']),
        stock(){
            const product = this.getProductById( this.product.id )

            if( !product ) return Number(this.product.stock)

            return Number(this.product.stock) - product.quantity
        }
    },
    components: {
        ImagesCarousel: () => import('../../shared/components/ImagesCarousel.vue')
    }
}
</script>

<style scoped>
   .row{
       height: 25rem;
       max-height: 25rem;
       overflow: hidden;
   }

   img{
       max-width: 100%;
       max-height: auto;
       object-fit: contain;
   }

   .col-md-5{
       max-height: 100%;
   }
</style>