<template>
    <div class="shopping-cart-grid">
      <div v-for="product in shoppingCart" :key="product.product_id" class="product-card">
            <div>
                <img :src="product.image" class="img" />
            </div>
            <div class="product-name">
                {{ product.product.name }}
            </div>
            <div class="count"> 
                <i class="fas fa-chevron-left" style="cursor:pointer" @click="changeOrder(product.product_id, false)" ></i><p>{{product.count}}</p><i style="cursor:pointer" @click="changeOrder(product.product_id, true)" class="fas fa-chevron-right"></i>

            </div>
      </div>
        
    </div>
</template>

<script>
import axios from 'axios';
import Cookies from 'js-cookie';
import { emit, on } from '../event-bus.js';

export default {
data() {
    return {
    shoppingCart: []
    };
},
watch: {

},
created() {
    
    this.test()
    on('changedOrder2', ()=>{
        this.test()
    })
  
},
methods: {
  handleEnterKeyPress() {
    
  },
  addToShoppingCart(product_id){
    let orders = undefined;
    if (Cookies.get('orders') !== undefined){
        orders = JSON.parse(Cookies.get('orders'));
    }
    console.log('orders')


    if (orders === undefined || !Array.isArray(orders)){
      orders = [product_id]
    } else {
      orders.push(product_id)
    }
    console.log('save cookie ' + orders)
    Cookies.set('orders', JSON.stringify(orders), { expires: 7 });
  },
    saveCookies(){
        let orders = []
        for(let key in this.shoppingCart){
            for(let i = 0; i < this.shoppingCart[key].count; i++){
                orders.push(this.shoppingCart[key].product_id)
            }
        }
        Cookies.set('orders', JSON.stringify(orders), { expires: 7 });
    },
    changeOrder(product_id, up){
        for(let key in this.shoppingCart){
            if(this.shoppingCart[key] .product_id == product_id){
                if(up){
                    this.shoppingCart[key] .count += 1
                } else {
                    this.shoppingCart[key] .count -= 1
                }
            }
        }
        this.saveCookies()
        emit("changedOrder")

    },
    test(){
        this.shoppingCart =[]
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
        for (let key in v){
            const api_ip = process.env.VUE_APP_API_BASE_IP;

            axios.get(`${api_ip}:8001/api/products/` + key, {
            
            })
            .then(response => {
            // Handle the successful response here
                let image = "images/public/" + response.data.image
                console.log(image)
                this.shoppingCart.push({"product_id": key, "count": v[key], 'product': response.data, 'image': image})
            })
            .catch(error => {
            // Handle errors here, such as displaying an error message to the user
            console.error('Error logging in:', error);
            });
            
        }
    }
  }
};
</script>

<style scoped>

.shopping-cart-grid{
    display: flex;
    flex-direction: column;
    background-color: whitesmoke;
    gap:20px;
    margin-left: 50px;
    margin-right: 50px;
    margin-top: 50px;
}

.product-card{
    display: flex;
    background-color: white;
    border-radius: 20px;
    padding: 20px;
}

.img{
    width: 300px;
    height: 300px;
}

.product-name{
    display: flex;
    justify-content: flex-start;
    flex-direction: column;
    width: 600px;
}

.count{
    display: flex;
    justify-content: center;
    align-items: center;
}

</style>