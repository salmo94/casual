import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios';
import router from "@/router/router";
import { loadFonts } from './plugins/webfontloader'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import 'vuetify/dist/vuetify.min.css';

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




















