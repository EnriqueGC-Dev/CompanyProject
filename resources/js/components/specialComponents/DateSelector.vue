<template>
  <div>
    <v-expand-transition>
      <div v-if="showPicker">
        <v-date-picker
          v-model="selectedDate"
          @update:model-value="onDateSelected"
          locale="es"
          first-day-of-week="1"
          show-adjacent-months
          max-height="420"
        />
      </div>
    </v-expand-transition>

    <v-text-field
      v-model="formattedDate"
      label="Selecciona una fecha"
      readonly
      @click="showPicker = true"
      prepend-icon="mdi-calendar"
      class="mt-4"
    />
  </div>
</template>


<script setup>
import { ref, computed } from 'vue'

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
