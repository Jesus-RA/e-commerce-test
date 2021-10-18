<template>
    <div>
        <b-button
            v-b-modal.create-user
            class="mb-4"
            size="sm"
            variant="dark"
        >
            Create user
        </b-button>

        <b-modal id="create-user" title="Add user">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" placeholder="Name" id="name" class="form-control" v-model="name">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" placeholder="email@webforcehq.com" id="email" class="form-control" v-model="email">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" placeholder="Password" id="password" class="form-control" v-model="password">
            </div>

            <template #modal-footer="{ ok, cancel }">
                <b-button variant="dark" @click="createUser(ok)">
                    Create
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

export default {
    
    data(){
        return {
            name: '',
            email: '',
            password: ''
        }
    },
    methods: {
        ...mapActions('userModule', ['storeUser']),
        async createUser(closeModal){
            
            const user = {
                name: this.name,
                email: this.email,
                password: this.password
            }

            const wasUserCreated = await this.storeUser( user )

            if(!wasUserCreated){

                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timeout: 3000,
                    icon: 'error',
                    title: `User with email ${ this.email } already exists`
                })

                return
            }

            this.$swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: `User ${ this.name } created`
            })

            this.clearData()
            closeModal()
        },
        clearData(){
            this.name = ''
            this.email = ''
            this.password = ''
        }
    }

}
</script>