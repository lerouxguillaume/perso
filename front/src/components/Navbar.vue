<template>
    <div>
        <!-- Image and text -->
        <b-navbar toggleable="lg" type="dark" variant="primary">
            <b-navbar-brand :to="{ name: 'homepage'}">Home</b-navbar-brand>

            <b-navbar-toggle target="nav_collapse" />

            <b-collapse is-nav id="nav_collapse">
                <b-navbar-nav>
                    <b-nav-item :to="{ name: 'nasa_list_image'}">Nasa</b-nav-item>
                    <b-nav-item :to="{ name: 'trading_list'}">Trading</b-nav-item>
                    <b-nav-item :to="{ name: 'video_list'}">Video</b-nav-item>
                    <b-nav-item :to="{ name: 'profile'}">Profile</b-nav-item>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                       <b-nav-item-dropdown right v-if="loggedIn">
                        <!-- Using button-content slot -->
                        <template slot="button-content"><em>User</em></template>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item @click="logout">Signout</b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item to="login" v-else>Login</b-nav-item>

                </b-navbar-nav>
            </b-collapse>
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
    .breadcrumb {
        background-color: whitesmoke;
    }
</style>