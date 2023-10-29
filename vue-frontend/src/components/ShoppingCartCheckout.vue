<template>
    <div class="sumar">
      <p> Sumar comanda </p>
      <p> Cost produse {{ total }} </p>
      <h3>Total: </h3>
      <h3> {{total}} </h3>
      <button class="custom-button" @click="continueButtonClick()">Continua</button>
    </div>
</template>

<script>
import axios from 'axios';
import Cookies from 'js-cookie';
import { emit, on } from '../event-bus.js';

export default {
    data() {
        return {
        shoppingCart: [],
        total: 0
        };
    },
    watch: {
    
    },
    created() {
        this.get_total()
            
    

        on("changedOrder", ()=>{
            this.get_total()
        })
      
    },
    methods: {
        get_total(){
            let orders = []
            if (Cookies.get('orders') !== undefined)
                orders = JSON.parse(Cookies.get('orders'));
            let v = {}
            for(let order of orders){
                if(order in v){
                    v[order] += 1
                } else {
                    v[order] = 1
                }
            }
            this.total = 0
            for (let key in v){
                const api_ip = process.env.VUE_APP_API_BASE_IP;

                axios.get(`${api_ip}:8001/api/products/` + key, {
                
                })
                .then(response => {
                // Handle the successful response here
                    let image = "images/public/" + response.data.image
                    console.log(image)
                    this.shoppingCart.push({"product_id": key, "count": v[key], 'product': response.data, 'image': image})
                    this.total += response.data.price * v[key]
                })
                .catch(error => {
                // Handle errors here, such as displaying an error message to the user
                console.error('Error logging in:', error);
                });
                
            }
        },
        continueButtonClick(){
            const token = localStorage.getItem("jwtToken");
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
            
            let orders = JSON.parse(Cookies.get('orders'));
            let v = {}
            for(let order of orders){
                if(order in v){
                    v[order] += 1
                } else {
                    v[order] = 1
                }
            }
            const api_ip = process.env.VUE_APP_API_BASE_IP;

            axios.post(`${api_ip}:8001/api/orders`, {
                'orders': v
            })
            .then(response => {
                console.log(response)
                Cookies.set('orders', "", { expires: -1 });
                this.shoppingCart=[]
                this.total = 0
                emit("changedOrder2", [])
                emit("changedOrder3", [])
            })
            .catch(error => {
                console.log(error)
                this.$router.push({ path: '/login'});
            });
        }
        
        
    }
}
    </script>
    

<style>
.sumar{
    display: flex;
    flex-direction: column;
    background-color: white;
    border-radius: 25px;
    justify-content: center;
    padding: 20px;
    margin-top:50px;
    height: 250px;
    width: 300px;
}

.custom-button {
    background: linear-gradient(to bottom, #007BFF, #0056b3);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease; /* Smooth transition for the background property */
  }

  .custom-button:hover {
    background: linear-gradient(to bottom, #4FAFFF, #007BFF);
  }
</style>