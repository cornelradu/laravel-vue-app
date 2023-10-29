<template>
  <div class="container">
    <SideBar_2 />
    <SideProducts />
    <ProductGrid />
  </div>
</template>

<script>
import ProductGrid from "../components/ProductGrid.vue";
import SideBar_2 from "../components/SideBar_2.vue";
import SideProducts from "../components/SideProducts.vue";

export default {
  components: {
    ProductGrid,
    SideBar_2,
    SideProducts,
  },
};
</script>

<style>
/* Basic styles for app layout */
.container {
  display: flex;
  position: relative;
  align-items: center;
  width: 100%;
  background-color: whitesmoke;
}
</style>
