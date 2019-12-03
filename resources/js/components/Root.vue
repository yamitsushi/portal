<template>
  <v-app id="inspire">
    <v-content>
      <router-view/>
      <Loading/>
    </v-content>
  </v-app>
</template>

<script>
  import Loading from './LoadingScreen.vue'

  export default {
    components: { Loading }
  }
</script>
