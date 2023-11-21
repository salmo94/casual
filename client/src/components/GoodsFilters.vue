
<template>

<!--  <v-container>-->
<!--  <v-sheet>-->
<!--    <h4 style="text-align: center">Ціна</h4>-->
<!--    <v-form>-->
<!--      <v-row align="center" justify="center">-->
<!--          <v-col-->
<!--              cols="12"-->
<!--              sm="6">-->
<!--            <v-text-field-->
<!--                @keydown.enter="sendQueryParams"-->
<!--                v-model="range.minValue"-->
<!--                :model-value="range.minValue"-->
<!--                label="Від"-->
<!--                variant="underlined"-->
<!--            ></v-text-field>-->
<!--          </v-col>-->
<!--          <v-col-->
<!--              cols="12"-->
<!--              sm="6">-->
<!--            <v-text-field-->
<!--                @keydown.enter="sendQueryParams"-->
<!--                v-model="range.maxValue"-->
<!--                :model-value="range.maxValue"-->
<!--                label="До"-->
<!--                variant="underlined"-->
<!--            ></v-text-field>-->
<!--          </v-col>-->
<!--        </v-row>-->
<!--          <v-row>-->
<!--          <v-col>-->
<!--            <h4  style="text-align: center">Бренд</h4>-->
<!--            <v-select-->
<!--                v-model="selectedProducers"-->
<!--                :items="producers"-->
<!--                label="Оберіть бренд..."-->
<!--                multiple-->
<!--            ></v-select>-->
<!--          </v-col>-->
<!--          </v-row>-->


<!--      <v-row>-->
<!--        <v-col>-->
<!--          <h4  style="text-align: center">Країна виробник</h4>-->
<!--          <v-select-->
<!--              multiple-->
<!--              label="Оберіть країну"-->
<!--              v-model="selectedCountries"-->
<!--              :items="countries"-->
<!--              density="comfortable"-->
<!--          ></v-select>-->
<!--        </v-col>-->
<!--      </v-row>-->
<!--          <v-row  align="center" justify="center" >-->
<!--          <v-col   cols="auto">-->
<!--            <v-btn color="blue"-->
<!--            @click="clearFilters"-->
<!--            >-->
<!--              Скинути фільтри-->
<!--            </v-btn>-->
<!--          </v-col>-->
<!--          </v-row>-->
<!--    </v-form>-->
<!--  </v-sheet>-->
<!--  </v-container>-->

</template>

<script>
import axios from "axios";

export default {
  name: "GoodsFilters",
  props: {
    minPrice:'',
    maxPrice: '',
    categoryId:'',
  },

  data() {
    return {
      range: {
        minValue: this.minPrice,
        maxValue: this.maxPrice,
      },
      selectedProducers: [],
      selectedCountries: [],
      producers:[],
      countries:[],
    }
  },

  methods: {
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
      this.range = {}
      this.selectedProducers = []
      this.selectedCountries = []
      this.sendQueryParams()

    },
  },
  watch:{
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
  }
}
</script>

<style scoped>

</style>