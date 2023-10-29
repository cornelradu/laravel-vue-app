<template>
  <div class="shopping-cart-container">
    <ShoppingCartElements />
    <ShoppingCartCheckout />
  </div>
</template>

<script>
import ShoppingCartElements from "@/components/ShoppingCartElements.vue";
import ShoppingCartCheckout from "@/components/ShoppingCartCheckout.vue";

export default {
  components: {
    ShoppingCartElements,
    ShoppingCartCheckout,
  },
};
</script>
<style>
.shopping-cart-container {
  display: flex;
  background-color: whitesmoke;
}
</style>
