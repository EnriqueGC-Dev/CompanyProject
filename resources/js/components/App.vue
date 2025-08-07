<template>
  <v-app class="bg-grey-lighten-3" >
    <v-main>
      <FirstLogin v-if="$store.state.user_firstlogin !== true"></FirstLogin>
      <v-layout v-else style="height: 100vh;" class="rounded rounded-md border ">
        <Navbar v-if="$store.state.authentication == true" @OpenCloseNavbar="OpenCloseNavbar"></Navbar>
        <Sidebar v-if="$store.state.authentication == true" v-model="vShowNavbar"></Sidebar>
          <v-main class="d-flex align-center justify-center">
            <v-container fluid> 
              <router-view></router-view>
            </v-container>
          </v-main>
      </v-layout>  
     </v-main>
  </v-app>
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