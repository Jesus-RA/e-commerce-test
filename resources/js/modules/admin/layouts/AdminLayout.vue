<template>
    <div>
        <Loader v-if="isLoading"/>
        
        <div v-else>
            <AdminNavbar />

            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
    computed: {
        ...mapState(['isLoading']),
    },
    components: {
        AdminNavbar: () => import('../components/AdminNavbar.vue'),
        Loader: () => import('../../shared/components/Loader.vue')
    }
}
</script>