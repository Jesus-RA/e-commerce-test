<template>
<div class="row">
    <div
        class="col-4 col-md-4 p-0"
        @click="goToProductDetails()"
    >
        <img
            v-for="(image, index) in product.images"
            :key="index"
            :src="image.url"
            class="img-fluid"
            :alt="product.name"
        >
    </div>
    <div class="col-8 col-md-8 p-0">
        <button class="btn btn-danger btn-sm float-right" @click="deleteProduct( product.id )">
            x
        </button>
        <div
            class="card-body"
            @click="goToProductDetails()"
        >
            <h5 class="card-title"> {{ product.name }} </h5>
            <p class="card-text"> {{ product.description }} </p>
            <p class="card-text">Quantity: {{ product.quantity }}</p>
        </div>
    </div>
</div>
</template>

<script>
import { mapMutations } from 'vuex'

export default {
    props: {
        product: {
            type: Object,
            required: true
        }
    },
    methods: {
        ...mapMutations('shoppingCartModule', ['deleteProduct']),
        goToProductDetails(){
            this.$router.push({ name: 'product-details', params: { slug: this.product.slug } })
        }
    }
}
</script>

<style scoped>

.row{
    max-height: 15rem;
    overflow: hidden;
    cursor: pointer;
}

.row img{
    object-fit: cover;
}

</style>