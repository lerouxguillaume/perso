<template>
    <div>
        <!-- Image and text -->
        <b-navbar variant="black" type="dark">
            <b-navbar-nav>
                <b-navbar-brand to="/">
                    <img src="https://placekitten.com/g/30/30" class="d-inline-block align-top" alt="BV" />
                    Home
                </b-navbar-brand>
                <b-nav-item to="/nasa">Nasa</b-nav-item>
                <b-nav-item to="/profile">Profil</b-nav-item>
                <b-nav-item to="/trading">Trade</b-nav-item>
                <b-nav-item-dropdown right v-if="loggedIn">
                    <!-- Using button-content slot -->
                    <template slot="button-content"><em>User</em></template>
                    <b-dropdown-item @click="logout">Logout</b-dropdown-item>
                </b-nav-item-dropdown>
                <b-nav-item to="/login" v-else right>Login</b-nav-item>
            </b-navbar-nav>
        </b-navbar>
        <b-breadcrumb :items="breadcrumbList" />
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "Navbar",
        data: () => {
            return {
                breadcrumbList : []
            }
        },
        computed: {
            ...mapGetters('auth', [
                'loggedIn'
            ])
        },
        methods: {
            ...mapActions('auth', [
                'logout'
            ]),
        },
        watch: {
            '$route' () {
                this.breadcrumbList = this.$route.meta.breadcumb
            }
        },
        mounted () {
            this.breadcrumbList = this.$route.meta.breadcumb
        }
    }
</script>

<style scoped>
    .breadcrumb{
        background-color: #222222;
    }
</style>