<template>
  <div
    class="col-md-4 mb-4"
    @click="$router.push({ name: 'product-details', params: { slug: product.slug } })"
  >
    <div class="card border-0 shadow-sm" style="width: 18rem;">
      <img
        v-for="(image, index) in product.images"
        :key="index"
        :src="image.url"
        class="card-img-top"
        :alt="product.name"
      >

      <div class="card-body">
        <h5 class="card-title">{{ product.name }}</h5>
        <p class="card-text">{{ product.description }}</p>
        <p>Price: {{ product.price }}</p>
        <button class="btn btn-primary btn-sm float-right">
          Add to cart
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      required: true
    }
  },
}
</script>

<style>

</style>