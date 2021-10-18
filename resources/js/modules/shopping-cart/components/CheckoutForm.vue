<template>
    <div>
        <b-button
            v-b-modal.checkout-modal
            class="mb-4"
            size="sm"
            variant="dark"
        >
            Go to checkout
        </b-button>

        <b-modal id="checkout-modal" title="Create order">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" placeholder="Name" id="name" class="form-control" v-model="$v.order.name.$model">
                <span v-if="$v.order.name.$error" class="d-block invalid-feedback">
                    Name is required
                </span>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" placeholder="Address" id="address" class="form-control" v-model="$v.order.address.$model">
                <span v-if="$v.order.address.$error" class="d-block invalid-feedback">
                    Address is required
                </span>
            </div>

            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" placeholder="state" id="state" class="form-control" v-model="$v.order.state.$model">
                <span v-if="$v.order.state.$error" class="d-block invalid-feedback">
                    State is required
                </span>
            </div>

            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" placeholder="country" id="country" class="form-control" v-model="$v.order.country.$model">
                <span v-if="$v.order.country.$error" class="d-block invalid-feedback">
                    Country is required
                </span>
            </div>

            <div class="form-group">
                <label for="card-number">Card number:</label>
                <input type="text" placeholder="Card number" id="card-number" class="form-control" v-model="$v.card.number.$model">
                <span v-if="$v.card.number.$error" class="d-block invalid-feedback">
                    Card number is required
                </span>
            </div>
            <div class="form-group">
                <label for="expiration">Expiration:</label>
                <input type="text" placeholder="expiration" id="expiration" class="form-control" v-model="$v.card.expiration.$model">
                <span v-if="$v.card.expiration.$error" class="d-block invalid-feedback">
                    Card expiration is required
                </span>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" placeholder="cvv" id="cvv" class="form-control" v-model="$v.card.cvv.$model">
                <span v-if="$v.card.cvv.$error" class="d-block invalid-feedback">
                    Card CVV is required
                </span>
            </div>

            <template #modal-footer="{ ok, cancel }">
                <b-button variant="dark" @click="confirmOrder(ok)">
                    Confirm Order
                </b-button>
                <b-button variant="danger" @click="cancel()">
                    Cancel
                </b-button>        
            </template>

        </b-modal>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import { required, minLength, maxLength } from 'vuelidate/lib/validators'

export default {
    data(){
        return {
            order: {
                name: null,
                address: null,
                state: null,
                country: null,
            },
            card: {
                number: null,
                expiration: null,
                cvv: null,
            }
        }
    },
    validations: {
        order: {
            name: { required },
            address: { required },
            state: { required },
            country: { required },
        },
        card: {
            number: { required, minLength: minLength(16), maxLength: maxLength(16) },
            expiration: { required, minLength: minLength(4), maxLength: maxLength(4) },
            cvv: { required, minLength: minLength(3), maxLength: maxLength(3) },
        }
    },
    computed: {
        ...mapState('shoppingCartModule', ['products'])
    },
    methods: {
        ...mapActions('shoppingCartModule', ['storeOrder']),
        confirmOrder(closeModal){

            if( this.$v.$invalid ){
                this.$v.$touch()
                return
            }
            
            const order = { ...this.order, products: this.products }

            this.storeOrder( order )

            this.$swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: '¡Order created successfully!'
            })

            closeModal()

        }
    }
}
</script>