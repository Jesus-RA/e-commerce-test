<template>
  <div class="container">
      <div class="row mt-5">
        <ProductCard
          v-for="product in getProducts"
          :key="product.id"
          :product="product"
        />
      </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    components: {
        ProductCard: () => import('../components/ProductCard.vue')
    },
    methods: {
      ...mapActions('productModule', ['fetchProducts'])
    },
    computed: {
      ...mapGetters('productModule', ['getProducts']),
    },
    created(){
      this.fetchProducts()
    },
}
</script>

<style>

</style>