<template>
  <div class="sidebar-container">
    <div class="sidebar">
      <div
        v-for="category in categories"
        :key="category.id"
        class="category-card"
      >
        <h3
          @mouseover="showElement = true"
          @mouseout="showElement = false"
          @click="searchCategory(category.id)"
          class="category-title"
        >
          {{ category.realname }}
        </h3>
      </div>
    </div>
    <div v-if="!showElement" class="carousel-container">
      <div class="wow-div">
        <div
          class="carousel-slide"
          :style="{ transform: `translateX(${-currentIndex * 100}%)` }"
        >
          <div
            v-for="(image, index) in images"
            :key="index"
            class="carousel-item"
          >
            <img :src="image" :alt="'Image ' + (index + 1)" />
          </div>
        </div>
        <button @click="prevSlide" class="prev-button">&lt;</button>
        <button @click="nextSlide" class="next-button">&gt;</button>
      </div>
    </div>
    <div v-if="showElement" class="subcategories">
      Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
      doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
      inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
      Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut
      fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem
      sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit
      amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora
      incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad
      minima veniam, quis nostrum exercitationem ullam corporis suscipit
      laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum
      iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae
      consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      apiUrl: process.env.VUE_APP_API_BASE_URL,
      showElement: false,
      currentIndex: 0,
      categories: [],
      images: [
        "images/carousel1.avif",
        "images/carousel2.avif",
        "images/carousel3.avif",
      ],
    };
  },
  created() {
    let url = `${this.apiUrl}/api/categories`;
    axios
      .get(url)
      .then((response) => {
        console.log(response);
        this.categories = response.data;
      })
      .catch((error) => {
        console.error(error);
      });
  },
  methods: {
    prevSlide() {
      this.currentIndex =
        (this.currentIndex - 1 + this.images.length) % this.images.length;
    },
    nextSlide() {
      this.currentIndex = (this.currentIndex + 1) % this.images.length;
    },
    searchCategory(category) {
      const queryParams = { ...this.$route.query };
      queryParams["category_id"] = category;
      this.$router.push({ path: "/search", query: queryParams });
    },
  },
};
</script>

<style scoped>
.sidebar-container {
  width: 100%;
  display: flex;
  height: 500px;
}

.sidebar {
  display: flex;
  flex-direction: column;
  border: 1px solid lightgray;
  width: 298px;
  min-width: 298px;
  background-color: white;
  margin-left: 50px;
  height: 450px;
}

.subcategories {
  width: 80%;
  margin: 0 auto;
  overflow: hidden;
  height: 100%;
}

.carousel-container {
  width: 80%;
  margin: 0 auto;
  overflow: hidden;
  height: 100%;
  margin-left: 0px;
}

.carousel-slide {
  display: flex;
  transition: transform 0.3s ease-in-out;
  height: 90%;
}

.carousel-item {
  flex: 0 0 100%; /* Ensure each image takes full width */
}

.carousel-item img {
  width: 100%;
  max-height: 100%;
}

.prev-button {
  cursor: pointer;
  bottom: 10px; /* Adjust the distance from the bottom as needed */
  background: red; /* Transparent background */
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  z-index: 59;
  bottom: 70px;
  left: 460px;
  position: absolute;
}

.next-button {
  cursor: pointer;
  bottom: 10px; /* Adjust the distance from the bottom as needed */
  background: red; /* Transparent background */
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  z-index: 59;
  bottom: 70px;
  left: 500px;
  position: absolute;
}

.category-card {
  cursor: pointer;
  width: 250px;
}

.category-title {
  background-color: white;
  height: 60px;
  display: flex;
  width: 298px;
  align-items: center;
  margin: 0px;
}
.category-title:hover {
  background-color: white;
  width: 299px;
  border-top-width: 1px;
  border-top-style: solid;
  border-bottom-width: 1px;
  border-bottom-style: solid;
  height: 60px;
  display: flex;
  align-items: center;
  z-index: 0;
}

.wow-div {
  position: relative;
  height: 100%;
}
</style>
