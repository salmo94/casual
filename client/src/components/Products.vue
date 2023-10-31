<template>
  <div id="mainBody">
    <div class="container">
      <div class="row">
        <!-- Sidebar ================================================== -->
        <div id="sidebar" class="span3">
          <side-bar></side-bar>
          <goods-filters
              :minPrice="$route.query.minPrice"
              :maxPrice="$route.query.maxPrice"
              :categoryId="categoryId"
          ></goods-filters>
        </div>
        <!-- Sidebar end=============================================== -->
        <div class="span9">
          <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Products Name</li>
          </ul>
          <hr class="soft"/>
          <form class="form-horizontal span6">
            <div class="control-group">
              <label class="control-label alignL">Sort By </label>
              <select>
                <option>Priduct name A - Z</option>
                <option>Priduct name Z - A</option>
                <option>Priduct Stoke</option>
                <option>Price Lowest first</option>
              </select>
            </div>
          </form>
          <br class="clr"/>
          <div class="tab-content">
            <div class="tab-pane  active" id="blockView">
              <ul class="thumbnails">
                <li v-for="(goods,index) in goodsList" :key="index" class="span3">
                  <div class="thumbnail">
                    <router-link :to="{name:'product-details',params:{goodsId:goods.id}}">
                      <img  class="product-img"
                           :src="'http://casual-backend.docker/' + goods.images[0].image_path"
                           alt="#"/></router-link>
                    <div class="caption">
                      <h5 class="goods-title">{{ goods.title }}</h5>
                      <h4 style="text-align:center"><a class="btn" href="#">Додати в кошик <i
                          class="icon-shopping-cart"></i></a> <a style="width: 87px" class="btn btn-primary"
                                                                 href="#">{{ goods.price }}грн</a></h4>
                    </div>
                  </div>
                </li>
              </ul>
              <hr class="soft"/>
            </div>
          </div>
          <a href="compair.html" class="btn btn-large pull-right">Compair Product</a>
          <div class="pagination">
            <ul>
              <li><a href="#">&lsaquo;</a></li>
              <li
                  v-for="pageNumber in totalPages"
                  :key="pageNumber">
                <router-link

                    :class="{
                            'current-page': page === pageNumber
                   }"
                    :to="{
                  name:'products',
                    params:{categoryId:$route.params.categoryId},
                    query:{page:pageNumber,minPrice:$route.query.minPrice,maxPrice:$route.query.maxPrice}}">
                  {{ pageNumber }}
                </router-link>
              </li>
              <li><a href="#">&rsaquo;</a></li>
            </ul>
          </div>
          <br class="clr"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import GoodsFilters from "@/components/GoodsFilters";
import SideBar from "@/components/SideBar";
import axios from "axios";

export default {

  props: {
    categoryId: {
      required: true
    },
  },
  name: "Products",
  components: {
    SideBar,
    GoodsFilters
  },
  data() {
    return {
      goodsList: {},
      perPage: 12,
      page: 1,
      totalPages: 0,

    }
  },
  methods: {
    getFilters(categoryId) {
      const requestData = {
        categoryId: categoryId,
        page: this.$route.query.page || this.page,
        perPage: this.perPage,
         minPrice: this.$route.query.minPrice,
         maxPrice: this.$route.query.maxPrice,
      }

      if (this.$route.query.producer !== undefined) {
        requestData.producer = this.$route.query.producer;

        console.log(this.$route.query.producer)
      }
      axios.get(`http://casual-backend.docker/goods/get-goods`, {
        params: requestData
      }).then(response => {
            this.totalPages = Math.ceil(response.data.goodsData.totalCount / this.perPage);
            this.goodsList = response.data.goodsData.data;
           // console.log(response.data.goodsData.data)
          }).catch(error => {
            console.error('Помилка запиту:', error);
          });
    },
  },
  watch: {
    $route: function () {
      this.getFilters(this.categoryId)
    }
  },
  created() {
    this.getFilters(this.categoryId)
  }
}
</script>

<style scoped>
.goods-title {
  text-align: center;
  width: 240px;
  height: 40px;
  display: block;
  overflow: hidden;
}
div.thumbnail {
  width: 260px;
  height: 300px;
}
.product-img {
  width: 150px;
  height: 125px;
}
.current-page {
  background: grey;
}
</style>