<template>
  <v-sheet class="mx-auto">
    <h4 style="text-align: center">Ціна</h4>
    <v-form>
        <v-row align="center" justify="center">
          <v-col
              cols="12"
              sm="6">
            <v-text-field
                @keydown.enter="sendQueryParams"
                v-model="range.minValue"
                :model-value="range.minValue"
                label="Від"
                variant="underlined"
            ></v-text-field>
          </v-col>

          <v-col
              cols="12"
              sm="6">
            <v-text-field
                @keydown.enter="sendQueryParams"
                v-model="range.maxValue"
                :model-value="range.maxValue"
                label="До"
                variant="underlined"
            ></v-text-field>
          </v-col>
        </v-row>
          <v-row>
          <v-col>
            <h4  style="text-align: center">Бренд</h4>
            <v-select
                v-model="selectedProducers"
                :items="producers"
                label="Оберіть бренд..."
                multiple
            ></v-select>
          </v-col>
          </v-row>


      <v-row>
        <v-col>
          <h4  style="text-align: center">Країна виробник</h4>
          <v-combobox
              v-model="selectedProducers"
              :items="producers"
              label="I use chips"
              multiple
              chips
          ></v-combobox>
        </v-col>
      </v-row>


          <v-row  align="center" justify="center" >
          <v-col   cols="auto">
            <v-btn color="blue"
            @click="clearFilters"
            >
              Скинути фільтри
            </v-btn>
          </v-col>
          </v-row>
    </v-form>
  </v-sheet>
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
      producers:[],
    }
  },

  methods: {
    sendQueryParams() {
      this.$router.push({
        name: 'products',
        params: {categoryId: this.categoryId},
        query: {minPrice: this.range.minValue, maxPrice: this.range.maxValue, producer: this.selectedProducers}
      });
    },

    getProducersList() {
      const requestData = {
        categoryId: this.$route.params.categoryId
      }
      axios.get(`http://casual-backend.docker/goods/get-producers`, {
        params: requestData
      })
          .then(response => {
            this.producers = response.data.producersList

            // console.log(this.producers)
          }).catch(error => {
        console.error('Помилка запиту:', error);
      });

    },

    clearFilters() {
      this.range = {}
      this.selectedProducers = []
      this.sendQueryParams()

    },
  },
  watch:{
    $route: function () {
      this.getProducersList()
    },
    selectedProducers() {
      this.sendQueryParams()
    }
  },

  created() {
    this.getProducersList()
  }
}
</script>

<style scoped>

</style>