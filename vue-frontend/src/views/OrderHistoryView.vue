<template>
  <div class="container">
    <div class="order" v-for="(value, key) in orders" :key="key">
        <p>Comanda #{{key}} la data de {{orders_timestamp[key]}}</p>
        <div v-for="item in value" :key="item.product_id" class="orderItem">
            <img class="img" :src="item.image"/>
            <div> {{item.product.name}} </div>
            <div># {{item.count}} Total: {{ item.count * item.product.price }} Lei </div>
        </div>
        
        <div>{{orders_total[key]}} Lei </div>
    </div>
    
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
        apiUrl: process.env.VUE_APP_API_BASE_URL,
        orders: {},
        orders_total : {},
        orders_timestamp: {}
    };
  },
  methods: {
    
  },
  created() {
      const token = localStorage.getItem("jwtToken");
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      axios.get(`${this.apiUrl}/api/orders`, {
        
      })
      .then(response => {
        // Handle the successful response here
        console.log('Order history:', response.data);
        this.orders = {}
        this.orders_total = {}
        this.orders_timestamp = {}
        for(let orderItem of response.data){

              axios.get(`${this.apiUrl}/api/products/` + orderItem.product_id, {
                
              })
              .then(response => {
                  let image = "images/public/" + response.data.image
                  
                  if(!(orderItem.order_id in this.orders)){
                    this.orders[orderItem.order_id] = [{"product_id": orderItem.product_id, "count": orderItem.count, image: image, "product": response.data}]
                    this.orders_total[orderItem.order_id] = orderItem.count * response.data.price;
                    this.orders_timestamp[orderItem.order_id] = orderItem.timestamp;
                  }
                  else{
                    this.orders[orderItem.order_id].push({"product_id": orderItem.product_id, "count": orderItem.count, image: image, "product": response.data})
                    this.orders_total[orderItem.order_id] += orderItem.count * response.data.price;
                    this.orders_timestamp[orderItem.order_id] = orderItem.timestamp;
                  }

                  
              })
              .catch(error => {
              console.error('Error logging in:', error);
              });             
        }
      })
      .catch(error => {
        console.error('Error logging in:', error);
      });
    }
};
</script>

<style scoped>
.img{
  width: 300px;
  height: 300px;
}

.container{
  display: grid;
  position: relative;
  justify-content: center;
  grid-template-columns: repeat(1, 1fr);
  grid-template-rows: 1fr;
  background-color: whitesmoke;
  height: 100%;
}

.order{
  margin-left:200px;
  width: 900px;
  margin-top:20px;
  display: flex;
  flex-direction: column;
  gap:10px;
  align-items: center;
  background-color: white;
  border-radius: 30px;
  padding: 20px;
}

.orderItem{
  height: 400px;
  min-width: 900px;
  display: flex;
  justify-content: center;
}
</style>
