<template>
    <v-app-bar :elevation="2">
      <v-app-bar-nav-icon @click="OpenCloseNavbar()"></v-app-bar-nav-icon>
      <v-btn @click="ToInicio()">inicio</v-btn>
      <v-btn @click="ToProyectos()">proyectos</v-btn>
      <v-btn @click="ToEmpleados()">empleados</v-btn>
    </v-app-bar>
</template>

<script>

export default {
  components: {  },

  data() {
      return {
        showNavBar: false
      };
  },

  methods: {
    
    ToInicio() {
      this.$router.push("/home").catch((err) => err);
    },

    ToProyectos() {
      this.$router.push("/proyectos").catch((err) => err);
    },
    
    ToEmpleados() {
      this.$router.push("/empleados").catch((err) => err);
    },

    OpenCloseNavbar() {
        this.$emit("OpenCloseNavbar");
    },
  }

}
  
</script>