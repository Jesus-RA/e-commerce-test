<template>
    <div class="container my-5">
        <h1 class="text-center">Products</h1>

        <CreateProductModal />
        <EditProductModal />

        <table class="table table-striped table-hover">

            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </thead>

            <tbody>
                <tr v-for="{ id, name, slug, description, price, stock, status } in getProducts" :key="id">
                    <td> {{ id }} </td>
                    <td> {{ name }} </td>
                    <td> {{ shortDescription( description ) }} </td>
                    <td> {{ price }} </td>
                    <td> {{ stock }} </td>
                    <td> {{ status == '1' ? 'Active' : 'Disabled' }} </td>
                    <td class="d-flex align-items-center justify-content-around px-0">

                        <button
                            class="btn btn-primary btn-sm"
                            @click="$router.push({ name: 'admin-product-details', params: { slug } })">
                            <i class="fas fa-eye"></i>
                        </button>
                        
                        <b-button
                            v-b-modal.edit-product
                            @click="setSelectedProductId( id )"
                            size="sm"
                            variant="warning"
                        >
                            <i class="fas fa-user-edit"></i>
                        </b-button>
                        <button class="btn btn-danger btn-sm" @click="handleDeleteProduct( id, name )">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'

export default {

    data(){
        return {
            showForm: false
        }
    },
    computed: {
        ...mapGetters('productModule', ['getProducts']),
    },
    methods: {
        ...mapActions('productModule', ['fetchProduct', 'deleteProduct']),
        ...mapMutations('productModule', ['setSelectedProductId']),
        shortDescription(description = ''){
            return description.split(' ').length > 8 
                ? description.split(' ').slice(0, 8).join(' ') + '...'
                : description
        },
        handleDeleteProduct(id, product){

            this.$swal.fire({
                title: `Delete product: ${ product }`,
                text: 'You won\'t be able to revert this, are you sure?',
                icon: 'warning',
                confirmButtonText: 'Delete',
                showCancelButton: true,
                cancelButtonColor: '#dc3545',
                confirmButtonColor: '#343a40',
                preConfirm: () => this.deleteProduct(id)
            }).then( result => {

                if( result.isConfirmed ){
                    this.$swal.fire({
                        title: 'Product deleted',
                        icon: 'success',
                        confirmButtonColor: '#343a40'
                    })
                }
            })

        }
    },
    components: {
        CreateProductModal: () => import('../../product/components/CreateProductModal.vue'),
        EditProductModal: () => import('../../product/components/EditProductModal.vue')
    }

}
</script>