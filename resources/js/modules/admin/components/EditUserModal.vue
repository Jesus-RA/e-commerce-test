<template>
    <b-modal id="edit-user" title="Add user" @show="handleOpenModal">

        <Loader v-if="!user" />

        <template v-else>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" placeholder="Name" class="form-control" v-model="user.name">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" placeholder="email@webforcehq.com"  class="form-control" v-model="user.email">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" placeholder="Password"  class="form-control" v-model="user.password">
            </div>
        </template>

        <template v-if="user" #modal-footer="{ ok, cancel }">
            <b-button variant="warning" @click="handleUpdateUser(ok)">
                Update
            </b-button>
            <b-button variant="danger" @click="cancel()">
                Cancel
            </b-button>        
        </template>

    </b-modal>
</template>

<script>
import { mapActions, mapState } from 'vuex'

export default {
    data(){
        return {
            user: {
                name: '',
                email: '',
                password: ''
            }
        }
    },
    computed: {
        ...mapState('userModule', ['selectedUserId'])
    },
    methods: {
        ...mapActions('userModule', ['fetchUser', 'updateUser']),
        handleUpdateUser(closeModal){

            const user = {
                id: this.selectedUserId,
                name: this.user.name,
                email: this.user.email,
                password: this.user.password,
            }
            this.updateUser( user )

            this.$swal({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: `User ${ this.user.name } successfully updated`
            })

            closeModal()
        },
        async handleOpenModal(){
            this.user = await this.fetchUser( this.selectedUserId )
        }
    },
    components: {
        Loader: () => import('../../shared/components/Loader.vue')
    }
}
</script>