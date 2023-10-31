import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios';
import router from "@/router/router";
import Paginate from "vuejs-paginate-next";
import { loadFonts } from './plugins/webfontloader'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

loadFonts()
const vuetify = createVuetify({
    components,
    directives,
})

const app = createApp(App)

createApp(App)
    .use(vuetify)
    .use(router)
    .mount('#app')
app.config.globalProperties.axios = axios
app.component('Paginate',Paginate)



















