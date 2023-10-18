import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios';
import router from "@/router/router";
import Paginate from "vuejs-paginate-next";

const app = createApp(App)

createApp(App)
    .use(router)
    .mount('#app')
app.config.globalProperties.axios = axios
app.component('Paginate',Paginate)