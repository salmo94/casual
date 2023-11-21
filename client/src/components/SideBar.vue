<template>
  <div class="col-lg-3">
    <!-- Shop Sidebar -->
    <div class="shop_sidebar">
      <div v-show="subCategories" class="sidebar_section">
        <div class="sidebar_title">Категорії</div>
        <ul class="sidebar_categories mb-5">
          <li v-for="(subCategory,index) in subCategories" :key="index"><a href="#">{{ subCategory.title }}</a></li>
        </ul>
      </div>
      <div>
        <div class="sidebar_title">Фільтрувати:</div>
        <div class="sidebar_subtitle">За ціною</div>
        <div>
          <form>
            <div class="price_range row mt-3">
              <div class="col">
                <input v-model="range.minValue" @keydown.enter="sendQueryParams" type="text" class="form-control">
              </div>
              <span class="mt-2">-</span>
              <div class="col">
                <input v-model="range.maxValue" @keydown.enter="sendQueryParams" type="text" class="form-control">
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="sidebar_section_brand">
        <div class="sidebar_subtitle brands_subtitle mb-5">Бренд</div>
        <div v-for="(brand,index) in producers" :key="index" class="form-check">
          <input v-model="selectedProducers" @change.once="sendQueryParams" class="form-check-input" type="checkbox"
                 :value="brand.title" id="defaultCheck1">
          <label class="form-check-label" for="defaultCheck1">
            {{ brand.title }}
          </label>
        </div>

      </div>

      <div class="sidebar_section">
        <div class="sidebar_subtitle brands_subtitle mb-5">Країна-виробник</div>
        <div v-for="(country,index) in countries" :key="index" class="form-check">
          <input v-model="selectedCountries" @change="sendQueryParams" class="form-check-input" :value="country.title"
                 type="checkbox" value="" id="defaultCheck1">
          <label class="form-check-label" for="defaultCheck1">
            {{ country.title }}
          </label>
        </div>
      </div>
      <div class="button_filter">
        <button @click="sendQueryParams" type="button" class="btn btn-success">OK</button>
        <button @click="clearFilters" type="button" class="btn btn-primary ml-3">Скинути</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "SideBar",
  props: {
    minPrice: '',
    maxPrice: '',
    categoryId: '',
  },

  data() {
    return {
      range: {
        minValue: this.minPrice,
        maxValue: this.maxPrice,
      },
      subCategories: [],
      selectedProducers: [],
      selectedCountries: [],
      producers: [],
      countries: [],
    }
  },

  methods: {

    fetchSubCategory(categoryId) {
      axios.get(`http://casual-backend.docker/api/category/get-sub-categories?categoryId=${categoryId}`)
          .then(response => {
            this.subCategories = response.data.subCategories
          })
          .catch(error => {
            console.log('Помилка завантаження:', error)
          })
    },

    getPriceRange(categoryId) {
      axios.get(`http://casual-backend.docker/api/goods/get-price-range?categoryId=${categoryId}`)
          .then(response => {
            this.range.minValue = response.data.lowestPrice
            this.range.maxValue = response.data.highestPrice
          })
          .catch(error => {
            console.log('Помилка завантаження:', error)
          })
    },
    sendQueryParams() {
      const queryData = {
        minPrice: this.range.minValue,
        maxPrice: this.range.maxValue,
        producer: this.selectedProducers,
        country: this.selectedCountries,
      }
      this.$router.push({
        name: 'products',
        params: {categoryId: this.categoryId},
        query: queryData
      });
    },

    getAttributesList() {
      const requestData = {
        categoryId: this.$route.params.categoryId
      }
      axios.get(`http://casual-backend.docker/api/goods/get-attribute-titles`, {
        params: requestData
      })
          .then(response => {
            this.producers = response.data.producersList
            this.countries = response.data.countryList
          }).catch(error => {
        console.error('Помилка запиту:', error);
      });

    },

    clearFilters() {
      this.range = []
      this.getPriceRange(this.categoryId)
      this.selectedProducers = []
      this.selectedCountries = []
      this.$router.push({
        name: 'products',
        params: {categoryId: this.categoryId},
        query: {}
      });
       this.sendQueryParams()
    },
  },
  watch: {
    $route: function () {
      this.getAttributesList()
    },
    selectedProducers() {
      this.sendQueryParams()
    },
    selectedCountries() {
      this.sendQueryParams()
    }
  },

  created() {
    this.getAttributesList()
    this.fetchSubCategory(this.categoryId)
    this.getPriceRange(this.categoryId)
  }
}
</script>

<style scoped>

.form-check {
  margin-left: 25px;
}

.price_range input {
  color: #0a0e14;
}

.button_filter {
  margin-left: 10px;
}

.button_filter button {
  width: 113px;
  line-height: 25px;
  text-align: center;
  color: white;
  margin-top: 20px;
}
</style>