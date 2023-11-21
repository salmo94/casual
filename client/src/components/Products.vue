<template>
  <div class="shop">
    <div class="container">
      <div class="row">
        <side-bar
            :minPrice="$route.query.minPrice"
            :maxPrice="$route.query.maxPrice"
            :categoryId="categoryId"
        ></side-bar>
        <div class="col-lg-9">
          <!-- Shop Content -->
          <div class="shop_content">
            <div class="shop_bar clearfix">
              <div class="shop_product_count">Знайдено <span>{{ totalCount }}</span> товарів</div>
              <div class="shop_sorting">
                <span>Сортувати:</span>
                <ul>
                  <li>
                    <span class="sorting_text">{{ selectedSort }}<i class="fas fa-chevron-down"></i></span>
                    <ul>
                      <li @click="selectSort(sortItems.cheap)" class="shop_sorting_button" data-isotope-option='{ "sortBy": "original-order" }'>
                        {{ sortItems.cheap }}
                      </li>
                      <li @click="selectSort(sortItems.expensive)" class="shop_sorting_button" data-isotope-option='{ "sortBy": "name" }'>
                        {{ sortItems.expensive }} </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>

            <div class="row product_grid">
              <div class="product_grid_border"></div>
              <!-- Product Item -->
              <div v-for="(goods,id) in goodsList" :key="id" class="col-4 product_item discount">
                <div class="product_border"></div>
                <div class="product_image d-flex flex-column align-items-center justify-content-center">
                  <router-link :to="{name:'product-details',params:{goodsId:goods.id}}">
                    <img class="product-img"
                         :src="'http://casual-backend.docker/' + goods.images[0].image_path"
                         alt="#"/></router-link>
                </div>
                <div class=" product_content">
                  <div class="product_price">{{ goods.price }}грн</div>
                  <div class="product_name">
                    <div><a href="#" tabindex="0">{{goods.title}}</a></div>
                  </div>
                </div>
                <div class="product_fav"><i class="fas fa-heart"></i></div>
                <ul class="product_marks">
                  <li class="product_mark product_discount">-25%</li>
                  <li class="product_mark product_new">new</li>
                </ul>
              </div>
            </div>
            <!-- Shop Page Navigation -->
            <div class="shop_page_nav d-flex flex-row">
              <div class="page_prev d-flex flex-column align-items-center justify-content-center"><i
                  class="fas fa-chevron-left"></i></div>
              <ul class="page_nav d-flex flex-row">
                <li v-for="pageNumber in totalPages"
                    :key="pageNumber">
                  <router-link
                      class="custom-router-link"
                      :class="{'current-page': page === pageNumber }"
                      :to="{
                    name:'products',
                    params:{categoryId:$route.params.categoryId},
                    query:{page:pageNumber,minPrice:$route.query.minPrice,maxPrice:$route.query.maxPrice}}">
                    {{ pageNumber }}
                  </router-link>
                </li>
              </ul>
              <div class="page_next d-flex flex-column align-items-center justify-content-center"><i
                  class="fas fa-chevron-right"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import axios from "axios";
import SideBar from "@/components/SideBar";

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
      range: {
        minPrice:0,
        maxPrice:0,
      },
      sortItems: {
        cheap: 'Від дешевих до дорогих',
        expensive: 'Від дорогих до дешевих',
      },
      selectedSort:'',
      goodsList: {},
      perPage: 12,
      page: 1,
      totalPages: 0,
      totalCount:0,
      sort: null,
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
        country: this.$route.query.country,
        sort: this.$route.query.sort
      }

      if (this.$route.query.producer !== undefined) {
        requestData.producer = this.$route.query.producer;
      }
      axios.get(`http://casual-backend.docker/api/goods/get-goods`, {
        params: requestData
      }).then(response => {
        this.totalPages = Math.ceil(response.data.goodsData.totalCount / this.perPage);
        this.goodsList = response.data.goodsData.data;
        this.totalCount = response.data.goodsData.totalCount
         //console.log(response.data.goodsData.data)
      }).catch(error => {
        console.error('Помилка запиту:', error);
      });
    },
    selectSort(data) {
      if (data === this.sortItems.cheap) {
        this.selectedSort = this.sortItems.cheap
        this.$route.query.sort = 'cheap'
      } else {
        this.selectedSort = this.sortItems.expensive
        this.$route.query.sort = 'expensive'
      }
      this.getFilters(this.categoryId)
    }
  },

  watch: {
    $route: function () {
      this.getFilters(this.categoryId)
    }
  },
  created() {
    this.getFilters(this.categoryId);
  }
}
</script>


<style scoped>

.custom-router-link {
  position: relative;
  display: inline-block;
}

.custom-router-link::before {
  content: '';
  position: absolute;
  top: -15px;
  bottom: -15px;
  left: -15px;
  right: -15px;
  background-color: transparent;
}
.product-img {
  width: 150px;
  height: 125px;
}


</style>
