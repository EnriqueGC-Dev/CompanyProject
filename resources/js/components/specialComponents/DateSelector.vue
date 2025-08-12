<template>
  <div>
    <v-dialog v-model="showPicker" width="auto">
      <div>
        <v-date-picker
          v-model="selectedDate"
          @update:model-value="onDateSelected"
          locale="es"
          first-day-of-week="1"
          show-adjacent-months
          max-height="420"
        />
      </div>
    </v-dialog>
    <v-text-field
      :label="label"
      v-model="formattedDate"
      readonly
      variant="outlined"
      color="primary"
      required
      clearable
      @click="showPicker = true"
    />
  </div>
</template>


<script setup>
import { ref, computed, } from 'vue'

const props = defineProps({
  label: {
    type: String,
    default: 'Seleccionar fecha'
  }
})

const showPicker = ref(false)
const selectedDate = ref(null)

const formattedDate = computed(() => {
  return selectedDate.value
    ? new Date(selectedDate.value).toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      })
    : ''
})

function onDateSelected(date) {
  selectedDate.value = date
  showPicker.value = false
}

</script>
