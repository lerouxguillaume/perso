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
            </b-navbar-nav>
        </b-navbar>
        <b-breadcrumb :items="breadcrumbList" />
    </div>
</template>

<script>
    export default {
        name: "Navbar",
        data: () => {
            return {
                breadcrumbList : []
            }
        },
        watch: {
            '$route' () {
                this.breadcrumbList = this.$route.meta.breadcumb
            }
        }
    }
</script>

<style scoped>
    .bg-black {
        background-color: black;
    }
</style>