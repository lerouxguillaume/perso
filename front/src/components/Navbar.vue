<template>
    <!-- Image and text -->
    <b-navbar variant="dark" type="dark">
        <b-navbar-nav>
            <b-navbar-brand to="/">
                <img src="https://placekitten.com/g/30/30" class="d-inline-block align-top" alt="BV" />
                Home
            </b-navbar-brand>
            <b-nav-item to="/nasa">Nasa</b-nav-item>
            <b-nav-item to="/profile">Profil</b-nav-item>
        </b-navbar-nav>
    </b-navbar>
</template>

<script>
    export default {
        name: "Navbar"
    }
</script>

<style scoped>

</style>