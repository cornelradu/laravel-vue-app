<template>
    <div v-if="this.isHovered || !this.isHovered && this.contentHovered" @mouseenter="hover()" @mouseleave="this.contentHovered=false" class="sidebar-container">
      <div class="sidebar">
        <div v-for="category in categories" :key="category.id" class="category-card">
          <h3 class="category-title" @click="searchCategory(category.id)"> {{category.name}}</h3>

        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { on } from '../event-bus.js';

  import axios from 'axios';

  export default {
    data() {
        return {
          apiUrl: process.env.VUE_APP_API_BASE_URL,
          isHovered: false,
          contentHovered: false,
          categories: [

          ]
        };
    },
    setup() {
        
    },
    created() {

      let url = `${this.apiUrl}/api/categories`;
      axios.get(url)
        .then(response => {
          console.log(response)
          this.categories = response.data;
         
        })
        .catch(error => {
          console.error(error);
          // Handle errors here
        });
        const add = () => {
            console.log("CALLBACK")
            this.isHovered = true
        };
        on('hovered', add)
        on('leave', () => {
            this.isHovered = false
        })
    },
    methods: {
      hover(){
        this.contentHovered = true;
      },
      searchCategory(category){
        this.$router.push({ path: '/search', query: { category_id: category } });
      }
    } 
    };
  </script>
  
  <style scoped>
    .sidebar-container{
      width: 200px;
      display: flex;
      height:500px;
      position: absolute;
      top:-10px;
      left:0px;
      z-index: 2;
    }

    .sidebar{
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      border: 1px solid lightgray;
      width: 250px;
      background-color: white;
      margin-left: 50px;
      height: 500px;
    }

    .subcategories{
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
    
    .prev-button,
    .next-button {
      cursor: pointer;
      bottom: 10px; /* Adjust the distance from the bottom as needed */
      background: rgba(255, 255, 255, 0.5); /* Transparent background */
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
    }
    
    .prev-button {
      left: 10px; /* Adjust the distance from the left as needed */
      z-index: 1;
    }
    
    .next-button {
      right: 10px; /* Adjust the distance from the right as needed */
      z-index: 1;
    }

    .category-card{
      cursor: pointer;
      width: 250px;
    }

    .category-title{
      background-color: white;
      height: 40px;
      display: flex;
      align-items: center;
      margin: 0px;
    }
    .category-title:hover{
      background-color: white;
      width: 251px;
      border-top-width: 1px;
      border-top-style: solid;
      border-bottom-width: 1px;
      border-bottom-style: solid;
      height: 40px;
      display: flex;
      align-items: center;
      z-index: 0;
    }
  </style>