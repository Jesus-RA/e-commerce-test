<template>
    <div class="container mt-5">
        <h1 class="text-center mb-4">
            Users
        </h1>
        
        <CreateUserModal />
        <EditUserModal />

        <table class="table table-striped table-hover">

            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </thead>

            <tbody>
                <tr v-for="{ id, name, email } in getUsers" :key="id">
                    <td> {{ id }} </td>
                    <td> {{ name }} </td>
                    <td> {{ email }} </td>
                    <td class="d-flex align-items-center justify-content-around px-0">
                        <b-button
                            v-b-modal.edit-user
                            @click="setSelectedUserId( id )"
                            size="sm"
                            variant="warning"
                        >
                            <i class="fas fa-user-edit"></i>
                        </b-button>
                        <button class="btn btn-danger btn-sm" @click="handleDeleteUser( id, name )">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'

export default {

    computed: {
        ...mapGetters('userModule', ['getUsers']),
    },
    methods: {
        ...mapActions('userModule', ['fetchUsers', 'deleteUser']),
        ...mapMutations('userModule', ['setSelectedUserId']),
        handleDeleteUser( id, name ){

            this.$swal.fire({
                title: `Delete user: ${ name }`,
                text: 'You won\'t be able to revert this, are you sure?',
                icon: 'warning',
                confirmButtonText: 'Delete',
                showCancelButton: true,
                cancelButtonColor: '#dc3545',
                confirmButtonColor: '#343a40',
                preConfirm: () => this.deleteUser(id)
            }).then( result => {

                if( result.isConfirmed ){
                    this.$swal.fire({
                        title: 'User deleted',
                        icon: 'success',
                        confirmButtonColor: '#343a40'
                    })
                }

            })

        }
    },
    created(){
        this.fetchUsers()
    },
    components: {
        CreateUserModal: () => import('../components/CreateUserModal.vue'),
        EditUserModal: () => import('../components/EditUserModal.vue')
    }
    
}
</script>