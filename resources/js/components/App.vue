<template>
    <v-layout style="height: 100vh;" class="rounded rounded-md border ">
      
      <Header @OpenCloseNavbar="OpenCloseNavbar"></Header>
      <Navbar v-model="vShowNavbar"></Navbar>
  
      <v-locale-provider>
        <v-main class="d-flex align-center justify-center mt-8">
          <v-container>
            <router-view></router-view>       
          </v-container>
        </v-main>
      </v-locale-provider>

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