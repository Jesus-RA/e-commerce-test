<template>
  <div
    class="col-md-4 mb-4"
    @click="$router.push({ name: 'product-details', params: { slug: product.slug } })"
  >
    <div class="card border-0 shadow-sm" style="width: 18rem;">
      <ImagesCarousel :images="product.images" />

      <div class="card-body">
        <h5 class="card-title">{{ product.name }}</h5>
        <p class="card-text">{{ product.description }}</p>
        <p>Price: {{ this.formatter.format(product.price) }}</p>

      </div>
    </div>
  </div>
</template>

<script>
import CurrencyFormatter from '../../shopping-cart/helpers/CurrencyFormatter'
export default {
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  data(){
    return {
      formatter: CurrencyFormatter
    }
  },
  components: {
    ImagesCarousel: () => import('../../shared/components/ImagesCarousel.vue')
  }
}
</script>

<style>

</style>