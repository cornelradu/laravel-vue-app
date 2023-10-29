<template>
    <div class="sideMisc">
        <div class="accordion-item accortion-item-1">
            <div class="accordion-header" >
              <span class="accordion-header-span-1">Pret</span>  <i v-if="isOpen" class="fas fa-chevron-right rotate-90 accordion-header-span" @click="toggleAccordion"></i> <i v-if="!isOpen" class="fas fa-chevron-right rotate-270 accordion-header-span" @click="toggleAccordion"></i>
            </div>
            <div v-if="isOpen" class="accordion-content accordion-content-price">
              
                <div v-for="(price, index) in prices" :key="index"><input :id="price"  @change="handleCheckboxChange" type="checkbox" class="price-checkbox" />{{price}}</div>
            </div>
          </div>
        <div class="accordion-item">
            <div class="accordion-header" >
              <span class="accordion-header-span-1"> Disponibil prin easybox </span> <i v-if="isOpen2" class="fas fa-chevron-right rotate-90 accordion-header-span" @click="toggleAccordion_2"></i> <i v-if="!isOpen2" class="fas fa-chevron-right rotate-270 accordion-header-span" @click="toggleAccordion_2"></i>
            </div>
            <div v-if="isOpen2" class="accordion-content accordion-content-price">
              
                <div><input type="checkbox" @change="handleCheckboxChange3" />Da</div>
            </div>
          </div>

          <div class="accordion-item">
            <div class="accordion-header">
              <span class="accordion-header-span-1"> Rating minim </span> <i v-if="isOpen3" class="fas fa-chevron-right rotate-90 accordion-header-span" @click="toggleAccordion_3"></i> <i v-if="!isOpen3" class="fas fa-chevron-right rotate-270 accordion-header-span" @click="toggleAccordion_3"></i>
            </div>
            <div v-if="isOpen3" class="accordion-content accordion-content-price">
              
                <div><input class="star-checkbox" id="5" @change="handleCheckboxChange2" type="checkbox" /><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i></div>
                <div><input class="star-checkbox" id="4" @change="handleCheckboxChange2" type="checkbox" /><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i></div>
                <div><input class="star-checkbox" id="3" @change="handleCheckboxChange2" type="checkbox" /><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i></div>
                <div><input class="star-checkbox" id="2" @change="handleCheckboxChange2" type="checkbox" /><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i></div>
                <div><input class="star-checkbox" id="1" @change="handleCheckboxChange2" type="checkbox" /><i class="fas fa-star" style="color: rgb(232, 232, 117);"></i></div>
            </div>
          </div>

          
    </div>
</template>

<script>


export default {
  props: {
    title: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      isChecked: [],
      isOpen: true,
      isOpen2: true,
      isOpen3: true,
      prices: [
        "sub 50", "50 - 100", "100 - 200", "200 - 500", "500 - 1000", "1000 - 1500", "1500 - 3000", "3000 - 5000", "5000 - 10000"
      ]
    };
  },
  methods: {
    toggleAccordion() {
      this.isOpen = !this.isOpen;
    },
    toggleAccordion_2(){
        this.isOpen2 = !this.isOpen2;
    },
    toggleAccordion_3(){
        this.isOpen3 = !this.isOpen3;
    },
    handleCheckboxChange(event){
        const itemCheckboxes = document.querySelectorAll('.price-checkbox');
        

        for(let price of this.prices){
            console.log(price)
            console.log(event.target.id)
            if (event.target.id === price && event.target.checked) {
                console.log('Checkbox with ID', price, 'is checked.');
                // Do something when the checkbox with the specified ID is checked
                const queryParams = { ...this.$route.query };
                queryParams.price = price;
                this.$router.push({ path: '/search', query: queryParams });
                
            } else if(event.target.id == price){
                const queryParams = { ...this.$route.query };
                
                delete queryParams['price'];
                console.log(queryParams)
                this.$router.push({ path: '/search', query: queryParams });
            }
        }

        itemCheckboxes.forEach(checkbox => {
            if(checkbox !== event.target)
            checkbox.checked =false;
        });

        //
    },
    handleCheckboxChange2(event){
        const itemCheckboxes = document.querySelectorAll('.star-checkbox');
        

        for(let star of [1,2,3,4,5]){

            if (event.target.id == "" + star && event.target.checked) {
                console.log('Checkbox with ID', star, 'is checked.');
                // Do something when the checkbox with the specified ID is checked
                const queryParams = { ...this.$route.query };
                queryParams.star = star;
                
                console.log(queryParams)
                this.$router.push({ path: '/search', query: queryParams });
                
            } else if(event.target.id == star){
                const queryParams = { ...this.$route.query };
                
                delete queryParams['star'];
                console.log(queryParams)
                this.$router.push({ path: '/search', query: queryParams });
            }
        }

        itemCheckboxes.forEach(checkbox => {
            if(checkbox !== event.target)
            checkbox.checked =false;
        });

        //
    },
    handleCheckboxChange3(event){
        if(!event.target.checked){
            const queryParams = { ...this.$route.query };
            delete queryParams['easybox'];
            this.$router.push({ path: '/search', query: queryParams });
        } else {
            const queryParams = { ...this.$route.query };
            queryParams['easybox'] = true;
            this.$router.push({ path: '/search', query: queryParams });
        }

    }
  }
};
</script>

<style>
.sideMisc{
    min-width: 300px;
    height: 100vh;
    background-color: transparent;
    margin-left: 20px;
    margin-right: 20px;
}

.accordion-header{
    display:  flex;
    justify-content: flex-start;
}

.accordion-item{
    background-color: white;
    border-radius: 5px;
    margin-top: 10px;
    padding: 10px;
    position: relative;
}

.accordion-header-span{
    justify-content: flex-end;
    position: absolute;
    top: 5px;
    right: 5px;
    cursor: pointer;
}

.accordion-header-span-1{
    justify-content: flex-start;
}

.accortion-item-1{
    margin-top: 60px;
}

.accordion-content-price{
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

.accordion-content-price div{
    display: flex;
    flex-direction: row;
    padding-left: 40px;
}

.rotate-90 {
    transform: rotate(-90deg);
}

.rotate-270 {
    transform: rotate(-270deg);
}
</style>