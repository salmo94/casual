<template>
  <header class="header">

    <!-- Top Bar -->

    <div class="top_bar">
      <div class="container">
        <div class="row">
          <div class="col d-flex flex-row">
            <div class="top_bar_contact_item">
              <div class="top_bar_icon"><img src="/images/phone.png" alt=""></div>
              +38 093 5933 779
            </div>
            <div class="top_bar_contact_item">
              <div class="top_bar_icon"><img src="/images/mail.png" alt=""></div>
              <a href="mailto:fastsales@gmail.com">antonio@gmail.com</a></div>
            <div class="top_bar_content ml-auto">
              <div class="top_bar_menu">
                <ul class="standard_dropdown top_bar_dropdown">
                  <li>
                    <a href="#">English<i class="fas fa-chevron-down"></i></a>
                    <ul>
                      <li><a href="#">Italian</a></li>
                      <li><a href="#">Spanish</a></li>
                      <li><a href="#">Japanese</a></li>
                    </ul>
                  </li>
                  <li>
                    <a href="#">$ US dollar<i class="fas fa-chevron-down"></i></a>
                    <ul>
                      <li><a href="#">EUR Euro</a></li>
                      <li><a href="#">GBP British Pound</a></li>
                      <li><a href="#">JPY Japanese Yen</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="top_bar_user">
                <div class="user_icon"><img src="/images/user.svg" alt=""></div>
                <div><a href="#">Реєстрація</a></div>
                <div><a href="#">Увійти</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Header Main -->

    <div class="header_main">
      <div class="container">
        <div class="row">

          <!-- Logo -->
          <div class="col-lg-2 col-sm-3 col-3 order-1">
            <div class="logo_container">
              <div class="logo"><router-link to="/">Casual</router-link></div>
            </div>
          </div>

          <!-- Search -->
          <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
            <div class="header_search">
              <div class="header_search_content">
                <div class="header_search_form_container">
                  <form action="#" class="header_search_form clearfix">
                    <input type="search" required="required" class="header_search_input" placeholder="Пошук товарів...">
                    <div class="custom_dropdown">
                      <div class="custom_dropdown_list">
                        <span class="custom_dropdown_placeholder clc">Всі категорії</span>
                        <i class="fas fa-chevron-down"></i>
                        <ul class="custom_list clc">
                          <li><a class="clc" href="#">All Categories</a></li>
                        </ul>
                      </div>
                    </div>
                    <button type="submit" class="header_search_button trans_300" value="Submit"><img
                        src="/images/search.png" alt=""></button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Wishlist -->
          <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
            <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
              <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                <div class="wishlist_icon"><img src="/images/heart.png" alt=""></div>
                <div class="wishlist_content">
                  <div class="wishlist_text"><a href="#">Улюблені</a></div>
                  <div class="wishlist_count">115</div>
                </div>
              </div>

              <!-- Cart -->
              <div class="cart">
                <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                  <div class="cart_icon">
                    <img src="/images/cart.png" alt="">
                    <div class="cart_count"><span>10</span></div>
                  </div>
                  <div class="cart_content">
                    <div class="cart_text"><a href="#">Кошик</a></div>
                    <div class="cart_price">$85</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Navigation -->

    <nav class="main_nav">
      <div class="container">
        <div class="row">
          <div class="col">

            <div class="main_nav_content d-flex flex-row">

              <!-- Categories Menu -->

              <div class="cat_menu_container">
                <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                  <div class="cat_burger"><span></span><span></span><span></span></div>
                  <div class="cat_menu_text">Каталог товарів</div>
                </div>
                <ul class="cat_menu">
                  <li v-for="(category,id) in categories" :key="id" class="hassubs">
                    <router-link  :to="{name:'products',params:{categoryId:category.id}}">{{ category.title }}
                      <i class="fas fa-chevron-right"></i>
                    </router-link>
                    <ul>
                      <li v-for="(subCategory,id) in category.child" :key="id" class="hassubs">
                        <router-link :to="{name:'products',params:{categoryId:subCategory.id}}">{{ subCategory.title }}<i class="fas fa-chevron-right"></i></router-link>
                        <ul>
                          <li v-for="(subChild,id) in subCategory.child" :key="id">
                            <router-link :to="{name:'products',params:{categoryId:subChild.id}}">{{ subChild.title }}<i class="fas fa-chevron-right"></i>
                            </router-link>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>

              <!-- Main Nav Menu -->

              <div class="main_nav_menu ml-auto">
                <ul class="standard_dropdown main_nav_dropdown">
                  <li><a href="#">Home<i class="fas fa-chevron-down"></i></a></li>
                  <li class="hassubs">
                    <a href="#">Super Deals<i class="fas fa-chevron-down"></i></a>
                    <ul>
                      <li>
                        <a href="#">Menu Item<i class="fas fa-chevron-down"></i></a>
                        <ul>
                          <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                        </ul>
                      </li>
                      <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                    </ul>
                  </li>
                  <li class="hassubs">
                    <a href="#">Featured Brands<i class="fas fa-chevron-down"></i></a>
                    <ul>
                      <li>
                        <a href="#">Menu Item<i class="fas fa-chevron-down"></i></a>
                        <ul>
                          <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                        </ul>
                      </li>
                      <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                    </ul>
                  </li>
                  <li class="hassubs">
                    <a href="#">Pages<i class="fas fa-chevron-down"></i></a>
                    <ul>
                      <li><a href="shop.html">Shop<i class="fas fa-chevron-down"></i></a></li>
                    </ul>
                  </li>
                  <li><a href="blog.html">Blog<i class="fas fa-chevron-down"></i></a></li>
                  <li><a href="contact.html">Contact<i class="fas fa-chevron-down"></i></a></li>
                </ul>
              </div>

              <!-- Menu Trigger -->

              <div class="menu_trigger_container ml-auto">
                <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                  <div class="menu_burger">
                    <div class="menu_trigger_text">menu</div>
                    <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import axios from "axios";

export default {
  name: "AppHeader",


  components: {},
  data() {
    return {
      categories: '',
    }
  },

  mounted() {
    this.fetchCategories();
  },

  methods: {
    fetchCategories() {
      axios.get('http://casual-backend.docker/api/category/get-categories')
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

<style scoped>

.logo-img {
  height: 65px;
  margin-top: -8px;

}

</style>