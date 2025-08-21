<template>
    <v-col cols="6"> <!-- Columna para la imagen de perfil -->
    <v-card fluid>
        <img 
            v-if="!User.user_photo" 
            src="../../images/no-profile-picture-icon.jpg" 
            class="rounded-circle mt-2" 
            style="width: 100%; height: auto; object-fit: cover;">
        <v-img
            v-if="User.user_photo"
            :src="User.user_photo"
            class="rounded-circle mt-2"
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
    <v-row class="mt-3">
        <v-spacer></v-spacer>
            <v-col cols="8" v-if="!User.user_photo"> <v-btn color="primary" @click="seleccionaImagen()">SUBIR IMAGEN</v-btn> </v-col>
            <v-col cols="8" v-if="User.user_photo"> <v-btn color="cancel" @click="borraImagen()">ELIMINAR IMAGEN</v-btn> </v-col>
        <v-spacer></v-spacer>
    </v-row>
    </v-col>
    <v-col cols="6"> <!-- Columna para la información del usuario -->
    <v-text-field
        v-model="User.name"
        label="Nombre"
        variant="outlined"
        color="primary"
        required
    ></v-text-field>
    <v-text-field
        v-model="User.user_phone"
        label="Número de teléfono"
        variant="outlined"
        color="primary"
        required
    ></v-text-field> 
    <DateSelector
        v-model="User.user_birthday"
        label="Fecha de nacimiento"
        variant="outlined"
        color="primary"
        required
        dense>
    </DateSelector>  
    </v-col>
</template>

<script>
export default {
  name: 'PerfilGeneral',
  props: ['User'],
  data() {
    return {
      image_name: null,
    }
  },
  mounted() {

  },
  methods: {
    seleccionaImagen() {
          this.$refs.file.click();
      },

      handleFileUpload(){
          this.User.user_photo = URL.createObjectURL(this.image_name)
      },

      borraImagen() {
          this.User.user_photo = null;
          this.image_name = null;
      },
  }  
}
</script>

