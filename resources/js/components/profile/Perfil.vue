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
            <v-form ref="profileForm" v-model="formValid">
              <!-- User Information Section -->
              <v-row>
                <v-col cols="12">
                  <h3 class="text-h6 mb-4">Información de Usuario</h3>
                </v-col>
                
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="profileData.name"
                    label="Nombre completo"
                    :rules="nameRules"
                    required
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="profileData.email"
                    label="Correo electrónico"
                    :rules="emailRules"
                    required
                    outlined
                    dense
                    type="email"
                  ></v-text-field>
                </v-col>
              </v-row>
              
              <!-- Profile Information Section -->
              <v-row class="mt-2">
                <v-col cols="12">
                  <h3 class="text-h6 mb-4">Información de Perfil</h3>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="6"> </v-col>
                <v-col cols="6" v-if="profileData.photoPreview">
                    <v-spacer></v-spacer>
                  <v-img
                    :src="profileData.photoPreview"
                    max-height="200"
                    max-width="200"
                    contain
                  ></v-img>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="profileData.phone"
                    label="Teléfono"
                    :rules="phoneRules"
                    outlined
                    dense
                    type="number"
                  ></v-text-field>
                </v-col>
                
                <v-col cols="12" md="6">
                  <v-file-input
                    v-model="profileData.photo"
                    label="Foto de perfil"
                    accept="image/*"
                    outlined
                    dense
                    prepend-icon="mdi-camera"
                    @change="onPhotoChange"
                  ></v-file-input>
                </v-col>
              </v-row>
              
              <!-- Company Information Section -->
              <v-row class="mt-2">
                <v-col cols="12">
                  <h3 class="text-h6 mb-4">Información de Empresa</h3>
                </v-col>
                
                <v-col cols="12">
                  <v-switch
                    v-model="profileData.isCompanyAdmin"
                    label="Administrador de empresa"
                    color="primary"
                    inset
                  ></v-switch>
                </v-col>
              </v-row>
              
              <!-- Action Buttons -->
              <v-row class="mt-4">
                <v-col cols="12" class="d-flex justify-space-between">
                  <v-btn color="cancel" @click="resetForm" dark>
                    <v-icon left>mdi-undo</v-icon>
                    Cancelar
                  </v-btn>
                  <v-btn color="primary" @click="saveProfile" :loading="saving" :disabled="!formValid" dark>
                    <v-icon left>mdi-content-save</v-icon>
                    Guardar Cambios
                  </v-btn>
                </v-col>
              </v-row>
            </v-form>
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
      formValid: false,
      saving: false,
      profileData: {
        name: '',
        email: '',
        phone: '',
        photo: null,
        photoPreview: null,
        isCompanyAdmin: false
      },
      nameRules: [
        v => !!v || 'El nombre es requerido',
        v => (v && v.length <= 100) || 'El nombre debe tener menos de 100 caracteres'
      ],
      emailRules: [
        v => !!v || 'El correo electrónico es requerido',
        v => /.+@.+\..+/.test(v) || 'El correo electrónico debe ser válido'
      ],
      phoneRules: [
        v => !v || /^\d{9,15}$/.test(v) || 'El teléfono debe tener entre 9 y 15 dígitos'
      ]
    }
  },
  mounted() {
    // Load user profile data when component is mounted
    this.loadProfileData();
  },
  methods: {
    loadProfileData() {
      // In a real application, this would fetch data from an API
      // For now, we'll use mock data
      this.profileData = {
        name: 'Juan Pérez',
        email: 'juan.perez@example.com',
        phone: '600123456',
        photo: null,
        photoPreview: null,
        isCompanyAdmin: true
      };
    },
    
    onPhotoChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.profileData.photo = file;
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          this.profileData.photoPreview = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        this.profileData.photo = null;
        this.profileData.photoPreview = null;
      }
    },
    
    resetForm() {
      this.$refs.profileForm.reset();
      this.loadProfileData();
    },
    
    async saveProfile() {
      if (!this.$refs.profileForm.validate()) {
        return;
      }
      
      this.saving = true;
      
      try {
        // In a real application, this would send data to an API
        // Example API call:
        /*
        const formData = new FormData();
        formData.append('name', this.profileData.name);
        formData.append('email', this.profileData.email);
        formData.append('phone', this.profileData.phone);
        if (this.profileData.photo) {
          formData.append('photo', this.profileData.photo);
        }
        formData.append('isCompanyAdmin', this.profileData.isCompanyAdmin);
        
        const response = await axios.post('/api/profile', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        */
        
        // Simulate API call delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Show success message
        this.$emit('show-message', {
          type: 'success',
          text: 'Perfil actualizado correctamente'
        });
      } catch (error) {
        // Show error message
        this.$emit('show-message', {
          type: 'error',
          text: 'Error al actualizar el perfil: ' + (error.response?.data?.message || error.message)
        });
      } finally {
        this.saving = false;
      }
    }
  }
}
</script>

<style scoped>
.primary {
  background-color: #113065 !important;
  color: white !important;
}
</style>