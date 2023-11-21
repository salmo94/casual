<template>
<!--  <div>-->
<!--    <h4 style="text-align: center">Лідери продажу</h4>-->
<!--  </div>-->
<!--  <div class="thumbnail" v-for="(goods,id) in salesLeadersList" :key="id">-->
<!--    <img :src="'http://casual-backend.docker/' + goods.images[0].image_path" title="Bootshop New Kindel" alt="Bootshop Kindel">-->
<!--    <div class="caption">-->
<!--      <h5>{{goods.title}}</h5>-->
<!--      <h4 style="text-align:center"><a class="btn" href="product_details.html">-->
<!--        <i class="icon-zoom-in"></i></a>-->
<!--        <a class="btn" href="#">Додати в кошик <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">{{goods.price}}грн</a></h4>-->
<!--    </div>-->
<!--  </div><br/>-->
<!--  <div class="thumbnail">-->
<!--    <img src="themes/images/payment_methods.png" title="Bootshop Payment Methods" alt="Payments Methods">-->
<!--    <div class="caption">-->
<!--      <h5>Методи оплати</h5>-->
<!--    </div>-->
<!--  </div>-->
</template>

<script>
import axios from "axios";

export default {
  name: "SalesLeaders",

  data() {
    return {
      salesLeadersList: {}
    }
  },


  methods: {
    getSalesLeaders() {
      axios.get(`http://casual-backend.docker/goods/get-sales-leaders`)
          .then(response => {
            this.salesLeadersList = response.data.salesLeaders
          }).catch(error => {
        console.error('Помилка запиту:', error);
      });

    }

  },

  created() {
    this.getSalesLeaders()
  }
}
</script>

<style scoped>

</style>