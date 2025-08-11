<template>
<v-dialog
      v-model="showPopUp"
      width="400"
      persistent >
      <v-card class="pa-4" max-width="400">
        <div class="text-center mb-4">
          {{this.PopUpText}}
        </div>
        <v-btn class="ma-2" color="primary" size="large" rounded="lg" @click="$emit('cancel')">
          Cerrar
        </v-btn>
      </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: ["PopUpText"],

    data(){
        return{
            showPopUp: false,
        }
    }
}
</script>