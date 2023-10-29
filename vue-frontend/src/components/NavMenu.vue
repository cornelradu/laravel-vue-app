    <template>
        <nav class="navbar3" v-if="isHeaderVisible">
            <img src="logo.svg" class="logo" />
            <div class="search-bar">
              <input v-model="searchTerm" @keyup.enter="handleEnterKeyPress" type="text" placeholder="Search products..." />
            </div>
            <div class="my-user" v-if="logged_in" @mouseenter="my_username_visible = true" @mouseleave="my_username_visible = false" >
              <div class="user-icon" ><i class="fas fa-user-circle"></i>{{username}}</div>
              <div v-if="my_username_visible" class="my-user-div">
                <div>
                    Salut {{ username }}
                </div>
                <div class="my-commands" @click="goToCommands()">
                  Comenzile mele
                </div>
                <div class="my-commands" @click="logout()">
                  Logout
                </div>
            </div>
          </div>
          <div v-if="!logged_in" class="my-user" @mouseenter="contul_meu_visible = true" @mouseleave="contul_meu_visible = false"><div class="nav-menu-button" ><i class="fas fa-user-circle"></i>Contul meu</div>
            <div v-if="contul_meu_visible" class="my-user-div">
                <div>
                    <i class="fas fa-user-circle"></i>
                    <p> Intra in contul tau emag si ai control asupra ofertelor.</p>
                </div>
                  <button class="IntraInCont custom-button2"  @click="this.$router.push({ path: '/login'});"> Intra in cont</button>
            </div>
          </div>
          <div><div class="nav-menu-button shoppingcart_button"  style="margin-right: 30px" @click="goToShoppingCart()"><div v-if="total_count_shopping_cart != 0" class='bulina'>{{total_count_shopping_cart}}</div><i class="fas fa-shopping-cart"></i>Cosul meu</div></div>
        </nav>
    <div class="navbar">
        <nav class="navbar1">
            <img src="logo.svg" class="logo" />
            <div class="search-bar">
              <input v-model="searchTerm" @keyup.enter="handleEnterKeyPress" type="text" placeholder="Search products..." />
            </div>
            <div class="my-user" v-if="logged_in" @mouseenter="my_username_visible = true" @mouseleave="my_username_visible = false" >
                <div class="user-icon" ><i class="fas fa-user-circle"></i>{{username}}</div>
                <div v-if="my_username_visible" class="my-user-div">
                  <div>
                      Salut {{ username }}
                  </div>
                  <div class="my-commands" @click="goToCommands()">
                    Comenzile mele
                  </div>
                  <div class="my-commands" @click="logout()">
                    Logout
                  </div>
              </div>
            </div>
            <div v-if="!logged_in" class="my-user" @mouseenter="contul_meu_visible = true" @mouseleave="contul_meu_visible = false"><div class="nav-menu-button" ><i class="fas fa-user-circle"></i>Contul meu</div>
              <div v-if="contul_meu_visible" class="my-user-div">
                  <div>
                      <i class="fas fa-user-circle"></i>
                      <p> Intra in contul tau emag si ai control asupra ofertelor.</p>
                  </div>
                    <button class="IntraInCont custom-button2" @click="this.$router.push({ path: '/login'});"> Intra in cont</button>
              </div>
            </div>
            <div><div class="nav-menu-button shoppingcart_button" @click="goToShoppingCart()"><div v-if="total_count_shopping_cart != 0" class='bulina'>{{total_count_shopping_cart}}</div><i class="fas fa-shopping-cart"></i>Cosul meu</div></div>
        </nav>
        <nav class="navbar2">
          <div class="products" @mouseover="emitHoverEvent()" @mouseleave="emitLeaveEvent()"><i class="fa-solid fa-bars" style="margin-top: 2px;margin-right:5px"></i> <a href="/"> Produse</a></div>
          <button class="custom-button4">Oferta zilei</button>
          <button class="custom-button4">Nutrition & Vitamins shop</button>
          <button class="custom-button4">Genius Deals</button>
          <button class="custom-button4">Genius</button>
          <button class="custom-button4">Resigilate</button>
          <button class="custom-button4">Ofertele eMAG</button>
      </nav>
    </div>
  </template>
  
  <script>
import { emit, on } from '../event-bus.js';
import axios from 'axios';
import Cookies from 'js-cookie';

  export default {
    data() {
        return {
        isHeaderVisible: false,
        contul_meu_visible: false,
        my_username_visible: false,
        username: "",
        logged_in: false,
        total_count_shopping_cart: 0
        };
    },
    mounted() {
      const api_ip = process.env.VUE_APP_API_BASE_IP;
      window.addEventListener('scroll', this.handleScroll);
      const token = localStorage.getItem("jwtToken");
        // Use the token in your API requests
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;


        axios.post(`${api_ip}:8001/api/me`, {
          
        })
        .then(response => {
          // Handle the successful response here
          console.log('Logged in successfully2222222123131:', response.data);
          this.logged_in = true;
          console.log(this.logged_in)
          this.username=response.data.name
        })
        .catch(error => {
          // Handle errors here, such as displaying an error message to the user
          console.error('Error logging in:', error);
        });

        let orders = []
              if (Cookies.get('orders') !== undefined)
                  orders = JSON.parse(Cookies.get('orders'));
        this.total_count_shopping_cart = orders.length
        
      on("logged_in", () => {
        const token = localStorage.getItem("jwtToken");
        // Use the token in your API requests
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;


        axios.post(`${api_ip}:8001/api/me`, {
          
        })
        .then(response => {
          // Handle the successful response here
          console.log('Logged in successfully2222222123131:', response.data);
          this.logged_in = true;
          console.log(this.logged_in)
          this.username=response.data.name
        })
        .catch(error => {
          // Handle errors here, such as displaying an error message to the user
          console.error('Error logging in:', error);
        });

        let orders = []
              if (Cookies.get('orders') !== undefined)
                  orders = JSON.parse(Cookies.get('orders'));
        this.total_count_shopping_cart = orders.length

      })
    },
    created() {
        on('changedOrder', ()=>{
          let orders = []
          if(Cookies.get('orders')){
            orders = JSON.parse(Cookies.get('orders'));
          }
          this.total_count_shopping_cart = orders.length
        })
        on('changedOrder3', ()=>{
          let orders = []
          if(Cookies.get('orders')){
            orders = JSON.parse(Cookies.get('orders'));
          }
          this.total_count_shopping_cart = orders.length
        })
    },
    methods: {
      handleEnterKeyPress() {
        // Perform some actions with this.searchQuery if needed
        // For example, navigate to a new route with the search query as a parameter
        const queryParams = { ...this.$route.query };
        console.log(this.$route.query)
        // Modify or add the specific query parameter
        queryParams.q = this.searchTerm;
        this.$router.push({ path: '/search', query: queryParams });
      },
      emitHoverEvent() {
         emit("hovered")
      },

      emitLeaveEvent(){
        emit("leave")
      },
      handleScroll() {
                    // Adjust the scroll threshold as needed (e.g., 100)
                    if (window.scrollY > 30) {
                        this.isHeaderVisible = true;
                    } else {
                        this.isHeaderVisible = false;
                    }
                },
      goToCommands(){

        this.$router.push({ path: '/order_history'});
        }
      ,goToShoppingCart(){
        this.$router.push({ path: '/shopping_cart'});
      },
      logout(){
        localStorage.removeItem("jwtToken");
        this.logged_in = false
      }

    },
    
    };
  </script>
  
  <style scoped>
 .navbar{
    display: flex;
    flex-direction: column;
    width:100%;
    background-color: yellow;
    padding: 0px;
 }

 .navbar1{
    background-color: white;
    display: flex;
    align-items: flex-start;
    flex-direction: row;
    align-items: center;
    height: 30px;
    padding: 12px;
 }

.navbar2{
  background: linear-gradient(to bottom right, #ff0000, blue);
  height: 30px;
  padding: 10px;
  display: flex;
  align-items: center; 

}

 /* SearchBar component styles */
.search-bar {
  
  border-radius: 15px;
  width: 100%;
  
}

.search-bar input{
  height: 30px;
  margin-left: 100px;
  width: 60%;
  border-radius: 15px;
}

.logo{
  width:150px;
}

.custom-button4 {
  background: transparent;
  border: none;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  transition: border 0.3s ease;
  border-radius: 15px; /* Adds rounded corners */
}

.custom-button4:hover {
  border: 1px solid white;
}

.products{
  color:black;
  background-color: white;
  height: 30px;
  margin-left: 60px;
  width: 110px;
  font-size: 20px;
  display: flex;
  justify-content: center;
  align-content: center;
  border-bottom-width: 0px;
  font-weight: bold;
  border-bottom-width: 0px;
  z-index: 1;
  border-radius: 10px;
}

.navbar3{
  top: 0;
  left: 0;
  position: fixed;
  z-index: 4;
  display: flex;
  width: 100%;
  background-color: white;
  height: 50px;
  padding: 5px;
  align-items: center;
  border-bottom: 1px solid blue;
}

.nav-menu-button{
  color:gray;
  width:100px;
  margin-left:10px;
}

.nav-menu-button:hover{
  color: black;
}

.my-user{
  position:relative;
  cursor: pointer;
}

.my-user-div{
  top: 30;
  left: -50px;
  position: absolute;
  width: 200px;
  height: 100px;
  display: flex;
  flex-direction: column;
  background-color: white;
  justify-content: flex-start;
  align-items: center;
  z-index: 2;
  border-radius: 10px;
  padding: 10px;
}

.my-user-div div{
  font-size: 15px;
  display: flex;
  align-items: center;
}

.IntraInCont{
  width: 200px;
  flex: 1 1 0;
}

.custom-button2 {
  background: linear-gradient(to bottom, #007BFF, #0056b3);
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s ease; /* Smooth transition for the background property */
}

.custom-butto2:hover {
  background: linear-gradient(to bottom, #4FAFFF, #007BFF);
}

.my-commands{
  background-color: white;
  width: 100%;
  cursor: pointer;
}

.my-commands:hover{
  background-color: whitesmoke;
}


.bulina{
  color:white;
  background-color: red;
  position: absolute;
  border-radius: 15px;
  font-size:10px;
  width: 15px;
  top:-7px;
  left:-7px;
}

.shoppingcart_button{
  position: relative;
  cursor: pointer;
}

.user-icon{
  display: flex;
  gap:10px;
  justify-content: center;
  align-items: center;
}

</style>