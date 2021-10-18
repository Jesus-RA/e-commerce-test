<template>
    <div>
        <GuestNavbar />

        <router-view></router-view>
    </div>
</template>

<script>

export default {
    components: {
        GuestNavbar: () => import('../components/GuestNavbar.vue')
    }
}
</script>