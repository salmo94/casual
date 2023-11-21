<template>



  <div class="single_product">
    <div class="container">
      <div class="row">
        <!-- Images -->

        <div class="col-lg-2 order-lg-1 order-2" style="max-height: 165px">
          <ul  v-for="(image,index) in goodsData.images" :key="index"  class="image_list">
            <li :data-image="absolutePath + image.image_path">  <img  style="width:100%" :src="absolutePath + image.image_path" alt="Photo"/></li>
          </ul>
        </div>
        <!-- Selected Image -->
          <template v-for="(image,index) in goodsData.images" :key="index">
        <div v-if="index === 0"  class="col-lg-5 order-lg-2 order-1">
          <div   class="image_selected"><img  style="width:100%" :src="absolutePath + image.image_path" alt="Photo"/></div>
        </div>
          </template>
        <!-- Description -->
        <div class="col-lg-5 order-3">
          <div class="product_description">
<!--            <div class="product_category">Laptops</div>-->
            <div class="product_name">{{goodsData.title}}</div>
            <div class="rating_r rating_r_4 product_rating"><i></i><i></i><i></i><i></i><i></i></div>
            <div class="product_text"><p>{{goodsData.description}}</p></div>
            <div class="order_info d-flex flex-row">
              <form action="#">
                <div class="clearfix" style="z-index: 1000;">
                  <!-- Product Quantity -->
                  <div class="product_quantity clearfix">
                    <span>Кількість: </span>
                    <input id="quantity_input" type="text" pattern="[0-9]*" value="1">
                    <div class="quantity_buttons">
                      <div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
                      <div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
                    </div>
                  </div>
                </div>
                <div class="product_price">{{ goodsData.price }}грн</div>
                <div class="button_container">
                  <button type="button" class="button cart_button_single">Додати в кошик</button>
                  <div class="product_fav"><i class="fas fa-heart"></i></div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="characteristic_table">
        <h3 class="mt-5 mb-5">Основні характеристики</h3>
        <table class="table table-bordered">
          <tbody>
          <tr  v-for="(attrDict,index) in dictionaryAttributes"
               :key="index"  class="techSpecRow">
            <td class="techSpecTD1">{{attributeTitles[attrDict.attribute_id]}}:</td>
            <td class="techSpecTD2">{{attributeValues[attrDict.value_id]}}</td>
          </tr>
          <tr  v-for="(attrFloat,index) in floatAttributes"
               :key="index"  class="techSpecRow">
            <td class="techSpecTD1">{{attributeTitles[attrFloat.attribute_id]}}:</td>
            <td class="techSpecTD2">{{attrFloat.value}}</td>
          </tr>
          <tr  v-for="(attrInt,index) in intAttributes"
               :key="index"  class="techSpecRow">
            <td class="techSpecTD1">{{attributeTitles[attrInt.attribute_id]}}:</td>
            <td class="techSpecTD2">{{attrInt.value}}</td>
          </tr>
          <tr  v-for="(attrText,index) in textAttributes"
               :key="index"  class="techSpecRow">
            <td class="techSpecTD1">{{attributeTitles[attrText.attribute_id]}}:</td>
            <td class="techSpecTD2">{{attrText.value}}</td>
          </tr>
          <tr  v-for="(attrBool,index) in boolAttributes"
               :key="index"  class="techSpecRow">
            <td class="techSpecTD1">{{attributeTitles[attrBool.attribute_id]}}:</td>
            <td class="techSpecTD2">{{attrBool.value}}</td>
          </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</template>

<script>

import axios from "axios";
export default {

  name: "ProductDetails",
  components: {

  },

  props:{
    goodsId:{
      required: true
    }
  },

  data() {
    return {
      dictionaryAttributes:'',
      floatAttributes:'',
      intAttributes:'',
      textAttributes:'',
      boolAttributes:'',
      attributeValues:'',
      attributeTitles: '',
      goodsData:'',
      absolutePath: 'http://casual-backend.docker/'
    }
  },

  methods: {
    getGoodsAttributes(goodsId) {
      axios.get(`http://casual-backend.docker/api/goods/get-goods-attributes?id=${goodsId}`)
          .then(response => {
            this.dictionaryAttributes = response.data.attrDict
            this.floatAttributes = response.data.attrFloat
            this.intAttributes = response.data.attrInt
            this.textAttributes = response.data.attrText
            this.boolAttributes = response.data.attrBool
            this.attributeValues = response.data.attributeValues
            this.attributeTitles = response.data.attributeTitles
           console.log(response.data)
          })
          .catch(error =>{
            console.log('Помилка завантаження:',error)
          })
    },
    getGoodsItem(goodsId) {
      axios.get(`http://casual-backend.docker/api/goods/get-goods-item?id=${goodsId}`)
          .then(response => {
            this.goodsData  = response.data.goodsItem
           /// console.log(this.goodsData.images)
          })
          .catch(error =>{
            console.log('Помилка завантаження:',error)
          })
    }
  },

  created() {
    this.getGoodsItem(this.goodsId)
    this.getGoodsAttributes(this.goodsId)
  }

}
</script>

<style scoped>

</style>