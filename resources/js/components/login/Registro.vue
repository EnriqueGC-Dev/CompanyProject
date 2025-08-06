<template>
  <v-layout class="d-flex align-center justify-center" style="height: 100vh; background: linear-gradient(135deg, #2196f3 0%, #21cbf3 100%);">
    <v-card class="pa-8" max-width="800" elevation="12" rounded="xl" style="backdrop-filter: blur(8px);">
      <div class="d-flex flex-column align-center mb-6">
        <v-avatar size="64" class="mb-2">
          <v-img src="https://cdn.vuetifyjs.com/images/logos/logo.svg"></v-img>
        </v-avatar>
        <span class="text-h5 font-weight-bold">Crear cuenta</span>
        <span class="text-subtitle-2 text-grey-darken-1">Regístrate para comenzar</span>
      </div>
      <v-card-text>
        <v-form>
          <v-text-field
            label="Nombre"
            v-model="name"
            prepend-inner-icon="mdi-account"
            variant="outlined"
            color="primary"
            class="mb-4"
            required
            :error-messages="nameError"
            @blur="validateName"
          ></v-text-field>
          <v-text-field
            label="Correo electrónico"
            v-model="email"
            prepend-inner-icon="mdi-email"
            variant="outlined"
            color="primary"
            class="mb-4"
            required
            :error-messages="emailError"
            @blur="validateEmail"
          ></v-text-field>        
          <div class="d-flex flex-row gap-4 mt-2">
            <v-btn class="ma-2" color="secondary" size="large" rounded="lg" @click="goToLogin" style="flex:1;">
              Volver al login
            </v-btn>
            <v-btn class="ma-2" color="primary" size="large" rounded="lg" @click="register" style="flex:1;">
              Registrarse
            </v-btn>
          </div>
        </v-form>
      </v-card-text>
    </v-card>
  </v-layout>
</template>

<script>
import axios from "axios";

export default {
  name: 'Registro',
  data() {
    return {
      name: '',
      email: '',
      nameError: '',
      emailError: '',
    }
  },
  computed: {

  },
  methods: {
    validateName() {
      this.nameError = this.name ? '' : 'El nombre es obligatorio';
    },
    validateEmail() {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      this.emailError = regex.test(this.email) ? '' : 'Introduce un correo electrónico válido';
    },
    register() {
      let credenciales = {
        name: this.name,
        email: this.email,
      };
      console.log(credenciales);
      axios
          .post("/api/user/signUp", credenciales)
          .then((response) => {
              alert("Usuario Creado Correctamente");
              this.$emit("changeView");
          })
          .catch((error) => {
              alert("Error al crear el Usuario");
          });
    },

    goToLogin() {
      this.$emit("changeView");
    }
  }
}
</script>

<style scoped>
.text-right {
  text-align: right;
}
</style>