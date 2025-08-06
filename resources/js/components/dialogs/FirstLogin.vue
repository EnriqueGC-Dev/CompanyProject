<template>
  <v-card class="pa-8" max-width="800" elevation="12" rounded="xl" style="backdrop-filter: blur(8px);">
    <div class="d-flex flex-column align-center mb-6">
      <v-avatar size="64" class="mb-2">
        <v-img src="https://cdn.vuetifyjs.com/images/logos/logo.svg"></v-img>
      </v-avatar>
      <span class="text-h5 font-weight-bold">Establecer Contraseña</span>
      <span class="text-subtitle-2 text-grey-darken-1">Cambia la contraseña para continuar</span>
    </div>
    <div>
        <span class="text-subtitle-2" :class="newPassword.length >= 8    ? 'text-green' : 'text-red'">La contraseña tiene al menos 8 caracteres.</span><br>
        <span class="text-subtitle-2" :class="newPassword.match(/[A-Z]/) ? 'text-green' : 'text-red'">La contraseña tiene al menos 1 letra mayuscula.</span><br>
        <span class="text-subtitle-2" :class="newPassword.match(/[a-z]/) ? 'text-green' : 'text-red'">La contraseña tiene al menos 1 letra minuscula.</span><br>
        <span class="text-subtitle-2" :class="newPassword.match(/[0-9]/) ? 'text-green' : 'text-red'">La contraseña tiene al menos 1 numero.</span><br>
        <span class="text-subtitle-2" :class="newPassword.match(/[\W_]/) ? 'text-green' : 'text-red'">La contraseña tiene al menos 1 simbolo especial.</span>
    </div>
    <v-card-text>
      <v-form>
        <v-text-field
          label="Contraseña"
          v-model="newPassword"
          type="password"
          prepend-inner-icon="mdi-lock"
          variant="outlined"
          color="primary"
          class="mb-2"
          required
          :error="!!newPasswordError"
          :error-messages="newPasswordError"
          @blur="validateNewPassword"
        ></v-text-field>
        <v-text-field
          label="Confirmar Contraseña"
          v-model="confirmPassword"
          type="password"
          prepend-inner-icon="mdi-lock"
          variant="outlined"
          color="primary"
          class="mb-2"
          required
          :rules="[rules.confirm]" 
        ></v-text-field>

        <div class="d-flex flex-row gap-4 mt-2">
          <v-btn class="ma-2" color="secondary" size="large" rounded="lg" @click="cancel" style="flex:1;">
            Cancelar
          </v-btn>
          <v-btn class="ma-2" color="primary" size="large" rounded="lg" @click="submit" style="flex:1;">
            Modificar
          </v-btn>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from "axios";

export default {
  name: "FirstLogin",
  data() {
    return {
      newPassword: "",
      confirmPassword: "",
      newPasswordError: "",

      rules: {
            confirm: (value) => value == this.newPassword || "Las contraseñas no coinciden.",
         },
    };
  },
  methods: {
    validateNewPassword() {
      const value = this.newPassword;
      // Al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo
      const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
      if (!regex.test(value)) {
        this.newPasswordError =
          "La contraseña es invalida.";
      } else {
        this.newPasswordError = "";
      }
    },
    submit() {
      let Self = this;
      let id = this.$store.state.user_id;
        
      let credenciales = {
          password: this.newPassword,
      };

      axios
          .post(`/api/user/setPassword/${id}`, credenciales)
          .then((response) => {
              if(response.data.status == 'OK'){

                  this.usuario = response.data[0];

                  console.log(this.$store.state.user_firstlogin);
                  this.$store.commit('SET_USER_FIRSTLOGIN', true);
                  console.log(this.$store.state.user_firstlogin);

                  }
          })
          .catch((error) => {
              alert('Usuario o contraseña incorrectos')
          });
    },
    cancel() {
      this.$store.dispatch("setLogout");
      this.$router.push("/");
    },
  },
};
</script>

<style scoped>
.center-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f5f6fa; /* Fondo similar al login */
}

.first-login-dialog {
  box-shadow: 0 2px 12px rgba(0,0,0,0.12);
  border-radius: 12px;
  padding: 32px 24px;
  background: #fff;
}

.actions {
  display: flex;
  gap: 1em;
  margin-top: 1em;
}

.text-green {
  color: #43a047 !important;
}
.text-red {
  color: #e53935 !important;
}
</style>
