<template>
  <div id="mainBody">
    <div class="container">
      <div class="row">
        <!-- Sidebar ================================================== -->
        <div id="sidebar" class="span3">
      <side-bar></side-bar>
        </div>
        <!-- Sidebar end=============================================== -->
        <div class="span9">
          <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li><a href="products.html">Products</a> <span class="divider">/</span></li>
            <li class="active">product Details</li>
          </ul>
          <div class="row">
            <div id="gallery" class="span3" >
              <template v-for="(image,index) in goodsData.images" :key="index">
              <a v-if="index === 0" :href="absolutePath + image.image_path">
                <img :src="absolutePath + image.image_path" style="width:100%" alt="Photo"/>
              </a>
              </template>
              <div  id="differentview" class="moreOptopm carousel slide">
                <div  class="carousel-inner">
                  <div class="item active">
                    <template v-for="(image,index) in goodsData.images" :key="index">
                    <a v-if="index !== 0" :href="absolutePath + image.image_path"> <img class="item-image" :src="absolutePath + image.image_path" alt=""/></a>
                    </template>
                  </div>
                </div>
                <!--
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
          -->

              </div>

              <div class="btn-toolbar">
                <div class="btn-group">
                  <span class="btn"><i class="icon-envelope"></i></span>
                  <span class="btn" ><i class="icon-print"></i></span>
                  <span class="btn" ><i class="icon-zoom-in"></i></span>
                  <span class="btn" ><i class="icon-star"></i></span>
                  <span class="btn" ><i class=" icon-thumbs-up"></i></span>
                  <span class="btn" ><i class="icon-thumbs-down"></i></span>
                </div>
              </div>

            </div>
            <div class="span6">
              <h3> {{goodsData.title}} </h3>
              <small>- (14MP, 18x Optical Zoom) 3-inch LCD</small>
              <hr class="soft"/>
              <form class="form-horizontal qtyFrm">
                <div class="control-group">
                  <label class="control-label"><span>{{goodsData.price}}грн</span></label>
                  <div class="controls">
                    <input type="number" class="span1" placeholder="Qty."/>
                    <button type="submit" class="btn btn-large btn-primary pull-right"> Додати в кошик <i class=" icon-shopping-cart"></i></button>
                  </div>
                </div>
              </form>

              <hr class="soft"/>
              <h4>Артикул: {{goodsData.article}}</h4>
              <form class="form-horizontal qtyFrm pull-right">
                <div class="control-group">
                  <label class="control-label"><span>Колір</span></label>
                  <div class="controls">
                    <select class="span2">
                      <option>Black</option>
                      <option>Red</option>
                      <option>Blue</option>
                      <option>Brown</option>
                    </select>
                  </div>
                </div>
              </form>
              <hr class="soft clr"/>
              <p id="description">
                {{goodsData.description}}
              </p>
              <a class="btn btn-small pull-right" href="#detail">Детільніше про товар</a>
              <br class="clr"/>
              <a href="#" name="detail"></a>
              <hr class="soft"/>
            </div>

            <div class="span9">
              <ul id="productDetail" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Характеристики</a></li>
                <li><a href="#profile" data-toggle="tab">Відгуки</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                  <h4>Характеристики</h4>
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
                  <h5>Опис</h5>
                  <p>
                   {{goodsData.description}}
                  </p>
                </div>
                <div class="tab-pane fade" id="profile">
               <h2>Поки що пусто</h2>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div> </div>
  </div>
</template>

<script>
import SideBar from "@/components/SideBar";
import axios from "axios";
export default {

  name: "ProductDetails",
  components: {
    SideBar
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
      axios.get(`http://casual-backend.docker/goods/get-goods-attributes?id=${goodsId}`)
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
      axios.get(`http://casual-backend.docker/goods/get-goods-item?id=${goodsId}`)
          .then(response => {
            this.goodsData  = response.data.goodsItem
            //console.log(this.goodsData)
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

.item-image {
  width: 29%;
  height: 65px;
}

</style>