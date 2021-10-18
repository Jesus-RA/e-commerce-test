<template>
    <div>
        <Loader v-if="isLoading"/>

        <router-view v-else></router-view>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from 'vuex'

export default {
    methods: {
        ...mapActions('productModule', ['fetchProducts']),
        ...mapActions('shoppingCartModule', ['getProductsFromLocalStorage']),
        ...mapMutations(['setIsLoading'])
    },
    computed: {
        ...mapState(['isLoading'])
    },
    async created(){
        this.setIsLoading(true)

        await this.fetchProducts()
        this.getProductsFromLocalStorage()

        this.setIsLoading(false)
    },
    components: {
        Loader: () => import('./modules/shared/components/Loader.vue')
    }
}
</script>