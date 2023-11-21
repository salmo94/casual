<template>
<v-app>
  <div class="super_container">
<app-header></app-header>
<router-view></router-view>
<app-footer></app-footer>
  </div>
</v-app>
</template>
<script>

import AppHeader from "@/components/AppHeader";
import AppFooter from "@/components/AppFooter";


export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
  },
}
</script>

<style>

</style>
