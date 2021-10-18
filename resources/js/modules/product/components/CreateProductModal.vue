<template>
    <div>
        <b-button
            v-b-modal.add-product
            class="mb-4"
            size="sm"
            variant="dark"
        >
            Add product
        </b-button>

        <b-modal id="add-product" title="Add new product">

            <h2 class="text-center">Product Information</h2>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" placeholder="Product name" class="form-control" v-model="$v.name.$model">
                <span v-if="$v.name.$error" class="d-block invalid-feedback">
                    Product name is required
                </span>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" rows="3" placeholder="Product description" class="form-control" v-model="$v.description.$model"></textarea>
                <span v-if="$v.description.$error" class="d-block invalid-feedback">
                    Product description is required
                </span>
            </div>

            <div class="form-group">
                <label for="images">Images:</label>
                <input type="file" id="images" class="form-control" multiple>
            </div>

            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" placeholder="Product price" class="form-control" v-model="$v.price.$model">
                <span v-if="$v.price.$error" class="d-block invalid-feedback">
                    Product price is required
                </span>
            </div>

            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" placeholder="Product stock" class="form-control" v-model="$v.stock.$model">
                <span v-if="$v.stock.$error" class="d-block invalid-feedback">
                    Product stock is required
                </span>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <div class="form-check ml-2">
                    <input class="form-check-input" type="checkbox" value="" id="status" v-model="$v.status.$model">
                    <label class="form-check-label" for="status">
                        Active
                    </label>
                </div>
            </div>

            <template #modal-footer="{ ok, cancel }">
                <b-button variant="dark" @click="addProduct(ok)">
                    Add product
                </b-button>
                <b-button variant="danger" @click="cancel()">
                    Cancel
                </b-button>        
            </template>

        </b-modal>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import { required } from 'vuelidate/lib/validators'

export default {
    data(){
        return {
            name: '',
            description: '',
            price: null,
            stock: null,
            status: false
        }
    },
    validations: {
        name: { required },
        description: { required },
        price: { required },
        stock: { required },
        status: { required },
    },
    methods: {
        ...mapActions('productModule', ['storeProduct']),
        async addProduct(closeModal){

            if( this.$v.$invalid ){
                this.$v.$touch()
                return
            }

            const images = document.getElementById('images').files

            const product = {
                name: this.name,
                description: this.description,
                price: this.price,
                stock: this.stock,
                status: this.status,
                images
            }

            const wasProductCreated = await this.storeProduct( product )

            if(!wasProductCreated){

                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timeout: 3000,
                    icon: 'error',
                    title: `Product ${ this.name } already exists`
                })

                return
            }


            closeModal()
            this.$swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: `${ this.name } added`
            })
            this.clearData()
        },
        clearData(){
            this.name = ''
            this.description = ''
            this.price = 0,
            this.stock = 0,
            this.status = false
        }
    }
}
</script>