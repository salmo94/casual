<template>
  <div id="mainBody">
    <div class="container">
      <div class="row">
        <!-- Sidebar ================================================== -->
        <side-bar></side-bar>
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
                      <img class="product-img"
                           :src="path + goods.image_path"
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
              <li><a href="#" @click="previousPage">&lsaquo;</a></li>
              <li
                  v-for="pageNumber in totalPages"
                  :key="pageNumber">
                <router-link
                    :class="{
                            'current-page': page === pageNumber
                   }"
                    :to="{name:'products',params:{categoryId:$route.params.categoryId},query:{page:pageNumber}}"

                    >
                  {{ pageNumber }}
                </router-link>
              </li>
              <li><a href="#" @click="nextPage">&rsaquo;</a></li>
            </ul>
          </div>
          <br class="clr"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

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
    SideBar
  },

  data() {
    return {
      goodsList: {},
      path: 'http://casual-backend.docker/',
      perPage: 12,
      page: 1,
      totalPages: 0,
    }
  },

  methods: {
    fetchGoodsData(categoryId) {
      if (!this.$route.query.page) {
        this.$route.query.page = this.page
      }

      axios.get(`http://casual-backend.docker/goods/get-goods-data`, {
        params: {
          id: categoryId,
          page: this.$route.query.page,
          perPage: this.perPage,
        }
      })
          .then(response => {
            this.totalPages = Math.ceil(response.data.totalCount / this.perPage);
            this.goodsList = response.data.goodsData;
          })
          .catch(error => {
            console.error('Помилка запиту:', error);
          });
    },
  },
  watch: {
    $route: function () {
      this.fetchGoodsData(this.categoryId)
    }
  },
  created() {
    this.fetchGoodsData(this.categoryId)
  },
}
</script>

<style scoped>
.goods-title {
  width: 250px;
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
  background: lightgrey;
}
</style>