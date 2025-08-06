<template>
  <v-layout class="d-flex align-center justify-center" style="height: 100vh; background: linear-gradient(135deg, #2196f3 0%, #21cbf3 100%);">
    <FirstLogin v-if="$store.state.user_firstlogin !== true"></FirstLogin>
    <v-layout v-else style="height: 100vh;" class="rounded rounded-md border ">
      <Navbar v-if="$store.state.authentication == true" @OpenCloseNavbar="OpenCloseNavbar"></Navbar>
      <Sidebar v-if="$store.state.authentication == true" v-model="vShowNavbar"></Sidebar>
      <v-locale-provider>
        <v-main class="d-flex align-center justify-center mt-8">
          <v-container> 
            <router-view></router-view>
          </v-container>
        </v-main>
      </v-locale-provider>
    </v-layout>
  </v-layout>
  
</template>

<script>

export default {

  data() {
      return {
        vShowNavbar: false
      };
  },

  methods: {
    OpenCloseNavbar: function () {
        this.vShowNavbar = !this.vShowNavbar;
    },
  }
  
}
  
</script>

<style scoped>
.app-background {
  min-height: 100vh;
  background: #f5f6fa; /* Mismo fondo que login */
}
</style>