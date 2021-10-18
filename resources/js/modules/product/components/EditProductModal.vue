<template>
    <div>
        <b-modal id="edit-product" :title="`Edit product: Pepto`" @show="handleOpenModal">

            <Loader v-if="!product" />

            <div v-if="product">
                <h2 class="text-center">Product Information</h2>

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" placeholder="Product name" class="form-control" v-model="product.name">
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" rows="3" placeholder="Product description" class="form-control" v-model="product.description"></textarea>
                </div>

                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" placeholder="Product price" class="form-control" v-model="product.price">
                </div>

                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" placeholder="Product stock" class="form-control" v-model="product.stock">
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" :value="product.status" id="status" v-model="product.status">
                        <label class="form-check-label" for="status">
                            Active
                        </label>
                    </div>
                </div>
            </div>

            <template v-if="product" #modal-footer="{ ok, cancel }">
                <b-button variant="dark" @click="handleUpdateProduct(ok)">
                    Update product
                </b-button>
                <b-button variant="danger" @click="cancel()">
                    Cancel
                </b-button>        
            </template>

        </b-modal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { required } from 'vuelidate/lib/validators'

export default {
    data(){
        return {
            product: {
                name: '',
                description: '',
                price: null,
                stock: null,
                status: false,
            }
        }
    },
    validations: {
        product: {
            name: { required },
            description: { required },
            price: { required },
            stock: { required },
            status: { required },
        }
    },
    computed: {
        ...mapGetters('productModule', ['getSelectedProductId'])
    },
    methods: {
        ...mapActions('productModule', ['fetchProduct', 'updateProduct']),
        handleUpdateProduct(closeModal){
            const productData = { id: this.getSelectedProductId, ...this.product }

            this.updateProduct( productData )
            this.clearData()
            this.$v.$reset()
            closeModal()

            this.$swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: 'Product updated successfully'
            })
        },
        clearData(){
            this.name = ''
            this.description = ''
            this.price = 0,
            this.stock = 0,
            this.status = false
        },
        async handleOpenModal(){
            this.product = await this.fetchProduct( this.getSelectedProductId )
        }
    },
    components: {
        Loader: () => import('../../shared/components/Loader.vue')
    }
}
</script>