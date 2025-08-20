<template>
  <v-container fluid class="pa-4">
    <v-row justify="center">
      <v-col cols="12" md="8" lg="6">
        <v-card>
          <v-card-title class="text-h5 font-weight-bold primary white--text">
            <v-icon left>mdi-account-edit</v-icon>
            Editar Perfil
          </v-card-title>
          
          <v-card-text class="mt-4">
              <v-row>
                <v-col> <v-btn block variant="flat" @click.stop="viewPage='GENERAL'"     :color = "viewPage=='GENERAL' ? 'primary' : '' ">GENERAL</v-btn> </v-col>
                <v-col> <v-btn block variant="flat" @click.stop="viewPage='CONTROL'"     :color = "viewPage=='CONTROL' ? 'primary' : '' ">CONTROL</v-btn> </v-col>
              </v-row>
              <v-row> <!-- Fila para la ventana de componente   -->
                <PerfilGeneral v-if="viewPage=='GENERAL'" v-bind:User="User"></PerfilGeneral>
                <PerfilControl v-if="viewPage=='CONTROL'" v-bind:User="User"></PerfilControl>
              </v-row>
              <v-row> <!-- Fila para los botones de acción -->
                <v-col cols="6">
                </v-col>
                <v-col cols="6">
                  <v-row class="mt-3">
                    <v-spacer></v-spacer>
                    <v-col cols="4">
                      <v-btn variant="outlined" color="primary" block>CANCELAR</v-btn>
                    </v-col>
                    <v-col cols="4">
                      <v-btn color="primary" block>GUARDAR</v-btn>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>


<script>
import APIUser from "../../interfaces/User";
import axios from "axios";

export default {
  name: 'Perfil',
  data() {
    return {
      viewPage: 'GENERAL', // Variable para controlar la vista actual
      User: Object.assign({}, APIUser.EmptyUser) // Instancia del usuario
    }
  },
  mounted() {
    this.initialize();
  },
  methods: {
    initialize: function() {
        this.getUserData();
      },

    
    getUserData: function() { // Método para obtener los datos del usuario
      let id = this.$store.state.user_id;

      axios
        .get(`/api/user/userdata/${id}`)
        .then((response) => {
          this.User = response.data.user;
          console.log(this.User);
        })
        .catch((error) => {
            alert('Error al cargar los proyectos de la compañia')
        });
      },
  }  
}
</script>

<style scoped>
.primary {
  background-color: #113065 !important;
  color: white !important;
}
</style>