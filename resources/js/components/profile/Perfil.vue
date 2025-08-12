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
              <v-row> <!-- Fila para los datos del usuario   -->
                <v-col cols="6"> <!-- Columna para la imagen de perfil -->
                  <v-card fluid>
                      <img v-if="!image_url" src="../../images/no-profile-picture-icon.jpg" class="rounded-circle" style="width: 100%; height: auto; object-fit: cover;">
                      <v-img
                          v-if="image_url"
                          :src="image_url"
                          class="rounded-circle"
                          :aspect-ratio="1"
                          style="width: 100%; height: auto; object-fit: cover;">
                        </v-img>
                  </v-card>
                  <v-file-input 
                      type="file" id="file" ref="file" v-on:change="handleFileUpload()"
                      style="display: none"
                      v-model="image_name"
                  >
                  </v-file-input>
                </v-col>
                <v-col cols="6"> <!-- Columna para la información del usuario -->
                  <h3 class="text-h6 mb-4">Información de Usuario:</h3> 
                  <v-text-field
                    label="Nombre"
                    variant="outlined"
                    color="primary"
                    required
                  ></v-text-field>
                  <v-text-field
                    label="Número de teléfono"
                    variant="outlined"
                    color="primary"
                    required
                  ></v-text-field> 
                  <DateSelector
                    label="Fecha de nacimiento"
                    variant="outlined"
                    color="primary"
                    required
                    dense>
                  </DateSelector>  
                  <v-select
                    label="Departamento"
                    variant="outlined"
                    color="primary"
                    :items="['Masculino', 'Femenino', 'Otro']"
                    required>
                  </v-select>
                </v-col>
              </v-row>
              <v-row> <!-- Fila para los botones de acción -->
                <v-col cols="6">
                  <v-row class="mt-3">
                    <v-spacer></v-spacer>
                      <v-col cols="6" v-if="!image_url"> <v-btn class="primary" @click="seleccionaImagen()">SUBIR IMAGEN</v-btn> </v-col>
                      <v-col cols="6" v-if="image_url"> <v-btn color="cancel" @click="borraImagen()">ELIMINAR IMAGEN</v-btn> </v-col>
                    <v-spacer></v-spacer>
                  </v-row>
                </v-col>
                <v-col cols="6">
                  <v-row class="mt-3">
                    <v-spacer></v-spacer>
                    <v-col cols="4">
                      <v-btn variant="outlined" color="primary" block>CANCELAR</v-btn>
                    </v-col>
                    <v-col cols="4">
                      <v-btn class="primary" block>GUARDAR</v-btn>
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
export default {
  name: 'Perfil',
  data() {
    return {
      image_url: null,
      image_name: null,
    }
  },
  mounted() {

  },
  methods: {
    seleccionaImagen() {
        console.log("Selecciona imagen");

          this.$refs.file.click();
      },

      handleFileUpload(){
          console.log("handleFileUpload");
          this.image_url = URL.createObjectURL(this.image_name)
      },

      borraImagen() {
          this.image_url = null;
          this.image_name = null;
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