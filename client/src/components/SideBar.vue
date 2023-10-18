<template>
  <div id="sidebar" class="span3">
    <div class="well well-small" style="height: 70px" ><a id="myCart" href="product_summary.html"><img
        src="../../public/themes/images/ico-cart.png" alt="cart">У вашому кошику: 3 товари <span
        class="badge badge-warning pull-right">$155.00</span></a></div>
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
      <li v-for="(category,index) in categories" :key="category.id" class="subMenu"><a
          @click="toggleSubMenu(index)">{{ category.title }} </a>
        <ul :style="{ display: activeSubMenu === index ? 'block' : 'none' }">
          <li v-for="subCategory in category.child" :key="subCategory.id">
            <router-link :to="{name:'products',params:{categoryId:subCategory.id}}"><i
                class="icon-chevron-right"></i>{{ subCategory.title }}
            </router-link>
          </li>
        </ul>
      </li>
    </ul>
    <br/>
    <br/>
  </div>
</template>

<script>

import axios from "axios";
import Products from "@/components/Products";

export default {
  components: {
    Products
  },
  data() {
    return {
      activeSubMenu: null,
      categories: '',

    }
  },

  mounted() {
    this.fetchCategories();
  },

  methods: {
    toggleSubMenu(index) {
      this.activeSubMenu = this.activeSubMenu === index ? null : index;
    },

    fetchCategories() {
      axios.get('http://casual-backend.docker/category/get-categories')
          .then(response => {
            this.categories = response.data.categories
          })
          .catch(error => {
            console.error('Помилка запиту:', error);
          });
    },
  }
}
</script>