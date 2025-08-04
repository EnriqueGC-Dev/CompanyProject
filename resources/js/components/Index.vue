<template>
  <v-app :class="getState">
      <v-main>
          <Login    v-if="authentication === false && show =='login'"    @changeView="changeView()"></Login>
          <Registro v-if="authentication === false && show =='registro'" @changeView="changeView()"></Registro>
          <App v-if="authentication"></App>
      </v-main>
  </v-app>
</template>

<script>
  export default {
    data () {
      return {  
        authentication: false,
        show: 'login',
      }
    },

    created() {
    },

    computed: {
      getState() {
            this.authentication = this.$store.getters.isUserLogged;
            return this.authentication ? "user-logged" : "user-anonymous";
        },
    },

    mounted() { 

      const Self = this;
        this.$store.dispatch('setLogin', function() {
            Self.authentication = Self.$store.getters.isUserLogged;

            if (!Self.authentication) {
                Self.$router.push("/").catch((err) => err);
            }
            if (Self.authentication && window.location.pathname == "/") {
                Self.$router.push("/home").catch((err) => err);
            }
        });
        console.log(this.authentication);
    },

    methods: {
      changeView: function () {
        this.show = this.show =='login' ? "registro" : "login" 
      }
    }
  }
</script>