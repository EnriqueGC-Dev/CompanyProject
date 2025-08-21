<template>
  <v-container fluid class="pa-4">
      <v-row>
        <v-col cols="12">
          <v-card elevation="0" fluid>
            <v-card-text>
              <v-row>
                <v-spacer></v-spacer>
                <v-switch v-model="User.user_active" label="Usuario Activo" baseColor="cancel" color="success"></v-switch>
              </v-row>
              <v-row>
                <v-spacer></v-spacer>
                <v-switch v-model="User.user_company_admin" label="Usuario Administrador" baseColor="cancel" color="success"></v-switch>
              </v-row>
              <v-select
                label="Departamento"
                variant="outlined"
                color="primary"
                :items="['Masculino', 'Femenino', 'Otro']"
                required>
              </v-select>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    
  </v-container>
</template>

<script>
export default {
  name: 'PerfilControl',
  props: ['User'],

  data() {
    return {
    }
  },
  mounted() {

  },
  methods: {

  }  
}
</script>

