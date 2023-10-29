<template>
  <div id="app">
    <div class="main-content">
      <NavMenu />
      <router-view />
    </div>
  </div>
</template>

<script>
import NavMenu from "./components/NavMenu.vue"; // Updated component name

export default {
  components: {
    NavMenu,
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  width: 100%;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}

.main-content {
  width: 100%;
  display: flex;
  flex-direction: column;
  height: 100%;
}
</style>
