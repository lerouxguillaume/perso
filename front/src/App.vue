<template>
  <div id="app">
    <Navbar/>
    <transition name="bounce">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
  import Navbar from "./components/Navbar";
  export default {
    name: 'app',
    components: {
      Navbar,
    }
  }
</script>

<style lang="scss">
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: white;
    min-height: 100%;
  }
  .bounce-enter-active {
    animation: bounce-in .5s;
  }
  @keyframes bounce-in {
    0% {
      transform: scale(0);
    }
    50% {
      transform: scale(1.5);
    }
    100% {
      transform: scale(1);
    }
  }
</style>