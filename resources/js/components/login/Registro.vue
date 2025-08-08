<template>
  <v-layout class="d-flex align-center justify-center" style="height: 100vh; background: linear-gradient(135deg, #2196f3 0%, #21cbf3 100%);">
    <v-card class="pa-4" max-width="800" elevation="12" rounded="xl" style="backdrop-filter: blur(8px);">
      <div class="d-flex flex-column align-center mb-3">
        <v-avatar size="64" class="mb-2">
          <v-img src="https://cdn.vuetifyjs.com/images/logos/logo.svg"></v-img>
        </v-avatar>
        <span class="text-h5 font-weight-bold">Crear cuenta</span>
        <span class="text-subtitle-2 text-grey-darken-1">Regístrate para comenzar</span>
      </div>
      <v-card-text>
        <v-form>
          <span class="text-subtitle-2 text-grey-darken-1">Datos Empresa:</span>
          <v-text-field
            label="Nombre Empresa"
            v-model="company"
            prepend-inner-icon="mdi-domain"
            variant="outlined"
            color="primary"
            required
            :error-messages="companyError"
            @blur="validateCompany"
          ></v-text-field>
          <v-text-field
            label="CIF Empresa"
            v-model="companyCIF"
            prepend-inner-icon="mdi-id-card"
            variant="outlined"
            color="primary"
            required
            :error-messages="companyCIFError"
            @blur="validateCIFCompany"
          ></v-text-field>
          <v-select
            label="Tiempo de Subscripción"
            v-model="companyType"
            :items="CompanyTypeItems"
            item-title="state"
            item-value="abbr"
            prepend-inner-icon="mdi-office-building"
            variant="outlined"
            color="primary"
            required>
          </v-select>
          <span class="text-subtitle-2 text-grey-darken-1">Datos Empleado Administrador:</span>
          <v-text-field
            label="Nombre Completo"
            v-model="name"
            prepend-inner-icon="mdi-account"
            variant="outlined"
            color="primary"
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
            required
            :error-messages="emailError"
            @blur="validateEmail"
          ></v-text-field>        
          <div class="d-flex flex-row gap-4 mt-2">
            <v-btn class="ma-2" color="secondary" size="large" rounded="lg" @click="goToLogin" style="flex:1;">
              Volver
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
      company: '',
      companyCIF: '',
      companyType: 1,
      name: '',
      email: '',
      CompanyTypeItems: [
        { state: '1 año - 50.00€', abbr: 1 },
        { state: '2 años - 75.00€', abbr: 2 },
        { state: '3 años - 100.00€', abbr: 3 }
      ],
      companyError: '',
      companyCIFError: '',
      nameError: '',
      emailError: '',
    }
  },
  computed: {

  },
  methods: {
    validateCompany() {
      this.companyError = this.company ? '' : 'La empresa es obligatoria';
    },
    validateCIFCompany() {
      const regex = /^[A-Za-z]{1}[0-9]{8}$/; // Simplified CIF validation
      this.companyCIFError = regex.test(this.companyCIF) ? '' : 'El CIF de la empresa es inválido';
    },

    validateName() {
      this.nameError = this.name ? '' : 'El nombre es obligatorio';
    },
    validateEmail() {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      this.emailError = regex.test(this.email) ? '' : 'Introduce un correo electrónico válido';
    },
    register() {
      let credenciales = {
        company: this.company,
        companyCIF: this.companyCIF,
        companyType: this.companyType,
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