<template>
    <div class="container mt-5">
        <div class="card shadow-sm p-5 border-0">
            <div class="row align-items-center">
                <div class="col-md-5 p-0">
                    <img
                        v-for="(image, index) in product.images"
                        :key="index"
                        :src="image.url"
                        :alt="product.name"
                        class="rounded"
                    >
                </div>

                <div class="col ml-md-4">
                    <h3 class="mb-3">{{ product.name }}</h3>

                    <p>
                        {{ product.description }}
                    </p>

                    <b>Price: {{ product.price }}</b>

                    <div class="input-group">
                        <label class="input-group-text" for="quantity">Quantity:</label>
                        <select class="form-select" id="quantity">
                            <option
                                v-for="quantity in 100"
                                :key="quantity"
                                value="quantity"
                            >
                                {{ quantity }}
                            </option>
                        </select>
                    </div>

                    <button class="btn btn-primary btn-sm mt-4">
                        Add to cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    props: {
        slug: {
            type: String,
            required: true,
        }
    },
    data(){
        return {
            product: null
        }
    },
    created(){
        this.product = this.getProductBySlug( this.slug )
    },
    computed: {
        ...mapGetters('productModule', ['getProductBySlug'])
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