<template>
    <v-app class="bg-grey-lighten-3">
      <FirstLogin v-if="$store.state.user_firstlogin !== true"></FirstLogin>
      <Sidebar v-if="$store.state.authentication == true" v-model="vShowNavbar"></Sidebar>
      <Navbar v-if="$store.state.authentication == true" @OpenCloseNavbar="OpenCloseNavbar"></Navbar>

      <v-main class="d-flex align-center justify-center">
        <v-container fluid style="height: calc(100vh - 64px); overflow-y: auto;">
          <router-view></router-view>
        </v-container>
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