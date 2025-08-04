<template>
  <v-layout class="d-flex align-center justify-center" style="height: 100vh; background: linear-gradient(135deg, #2196f3 0%, #21cbf3 100%);">
    <v-card class="pa-8" max-width="800" elevation="12" rounded="xl" style="backdrop-filter: blur(8px);">
      <div class="d-flex flex-column align-center mb-6">
        <v-avatar size="64" class="mb-2">
          <v-img src="https://cdn.vuetifyjs.com/images/logos/logo.svg"></v-img>
        </v-avatar>
        <span class="text-h5 font-weight-bold">Bienvenido</span>
        <span class="text-subtitle-2 text-grey-darken-1">Inicia sesión para continuar</span>
      </div>
      <v-card-text>
        <v-form>
          <v-text-field
            label="Usuario"
            v-model="username"
            prepend-inner-icon="mdi-account"
            variant="outlined"
            color="primary"
            class="mb-4"
            required
          ></v-text-field>
          <v-text-field
            label="Contraseña"
            v-model="password"
            type="password"
            prepend-inner-icon="mdi-lock"
            variant="outlined"
            color="primary"
            class="mb-2"
            required
          ></v-text-field>
          <div class="d-flex justify-end mb-4">
            <v-btn variant="text" size="small" color="primary">¿Olvidaste tu contraseña?</v-btn>
          </div>
          <div class="d-flex flex-row gap-4 mt-2">
            <v-btn color="primary" size="large" rounded="lg" @click="login" style="flex:1;">
              Iniciar Sesión
            </v-btn>
            <v-btn class="ml-3" color="secondary" size="large" rounded="lg" @click="createAccount" style="flex:1;">
              Crear cuenta
            </v-btn>
          </div>
        </v-form>
      </v-card-text>
    </v-card>
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      password: ''
    }
  },
  methods: {
    login() {
      // Aquí va la lógica de autenticación
    },
    createAccount() {
      this.$emit("changeView");
    }
  }
}
</script>