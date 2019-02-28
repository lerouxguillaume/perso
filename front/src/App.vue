<template>
  <div id="app">
    <Navbar/>
    <router-view></router-view>
  </div>
</template>

<script>
  import Navbar from "./components/Navbar";
  import ImageOfTheDay from "./components/ImageOfTheDay";
  import ListNasaImages from "./components/ListNasaImages";
  export default {
  name: 'app',
  components: {
    ListNasaImages,
    ImageOfTheDay,
    Navbar,
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 20px;
}
</style>
