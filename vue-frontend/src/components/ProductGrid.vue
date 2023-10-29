<template>
  <div class="product-grid">
    <div v-for="product in products" :key="product.id" class="product-card">
      <img :src="product.image" alt="Product" class="product-image" />
      <div class="product-title">{{ product.name }}</div>
      <div>
        <i
          v-for="index in product.star"
          :key="index"
          class="fas fa-star"
          style="color: rgb(232, 232, 117)"
        ></i>
      </div>
      <p class="product-price">{{ product.price }} Lei</p>

      <button class="custom-button" @click="addToShoppingCart(product.id)">
        <i class="fas fa-shopping-cart"></i>Adauga in cos
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Cookies from "js-cookie";
import { emit } from "../event-bus.js";

export default {
  data() {
    return {
      apiUrl: process.env.VUE_APP_API_BASE_URL,
      query: this.$route.query.q,
      category_id: this.$route.category_id,
      price: this.$route.price,
      star: this.$route.star,
      easybox: this.$route.easybox,
      products: [],
    };
  },
  watch: {
    // Watch for changes in the query parameters
    "$route.query": {
      immediate: true, // Call the handler immediately when the component is created
      handler(newQuery, oldQuery) {
        console.log(oldQuery);
        this.query = newQuery["q"];
        this.category_id = newQuery["category_id"];
        this.price = newQuery["price"];
        this.star = newQuery["star"];
        this.easybox = newQuery["easybox"];
        this.handleEnterKeyPress();
      },
    },
  },
  created() {},
  methods: {
    handleEnterKeyPress() {
      let q = this.query;
      let url = `${this.apiUrl}/api/products`;
      let atLeastOnce = false;

      if (
        q !== undefined ||
        this.category_id !== undefined ||
        this.price == undefined ||
        this.star ||
        this.easybox
      ) {
        atLeastOnce = true;
      }
      if (atLeastOnce) {
        url += "?";
      }

      if (this.query !== undefined) {
        url += "q=" + this.query + "&";
      }

      if (this.category_id !== undefined) {
        url += "category_id=" + this.category_id + "&";
      }

      if (this.price !== undefined) {
        url += "price=" + encodeURIComponent(this.price) + "&";
      }

      if (this.star !== undefined) {
        url += "star=" + this.star + "&";
      }

      if (this.easybox !== undefined) {
        url += "easybox=" + this.easybox + "&";
      }

      axios
        .get(url)
        .then((response) => {
          this.products = response.data;
          console.log(this.products);
          for (let product of this.products) {
            product.image = "images/public/" + product.image;
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    addToShoppingCart(product_id) {
      let orders = undefined;
      if (Cookies.get("orders") !== undefined) {
        orders = JSON.parse(Cookies.get("orders"));
      }
      console.log("orders");

      if (orders === undefined || !Array.isArray(orders)) {
        orders = [product_id];
      } else {
        orders.push(product_id);
      }
      console.log("save cookie " + orders);
      Cookies.set("orders", JSON.stringify(orders), { expires: 7 });
      emit("changedOrder3");
    },
  },
};
</script>

<style scoped>
.product-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  height: 100%;
  gap: 20px;
  padding-top: 30px;
}

@media screen and (max-width: 1300px) {
  .product-grid {
    grid-template-columns: repeat(3, 1fr); /* Adjust the width for phones */
  }
}

@media screen and (max-width: 1000px) {
  .product-grid {
    grid-template-columns: repeat(2, 1fr); /* Adjust the width for phones */
  }
}

.product-card {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: center;
  display: flex;
  flex-direction: column;
  height: 400px;
}

.product-image {
  max-width: 200px;
  margin: 0 auto 10px;
}

.product-title {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 3; /* Number of lines to show before truncating */
  -webkit-box-orient: vertical;
}

.product-price {
  font-weight: bold;
  color: red;
  justify-content: flex-start;
  margin-left: -120px;
}

.custom-button {
  background: linear-gradient(to bottom, #007bff, #0056b3);
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s ease; /* Smooth transition for the background property */
}

.custom-button:hover {
  background: linear-gradient(to bottom, #4fafff, #007bff);
}
</style>
