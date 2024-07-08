<template>
    <div>
      <PrimaryButton @click="triggerFileInput">Cargar CSV</PrimaryButton>
      <input type="file" ref="fileInput" @change="loadCsv" style="display: none;" />
      <div v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>
    </div>
  </template>

  <script>
  import Papa from 'papaparse';
  import PrimaryButton from '@/Components/PrimaryButton.vue';

  export default {
    components: {
      PrimaryButton,
    },
    data() {
      return {
        errorMessage: '',
      };
    },
    methods: {
      triggerFileInput() {
        this.$refs.fileInput.click();
      },
      loadCsv(event) {
        const file = event.target.files[0];
        if (file) {
          this.errorMessage = '';
          Papa.parse(file, {
            header: true,
            dynamicTyping: true,
            complete: this.updateData,
            error: this.handleError,
          });
        }
      },
      updateData(results) {
        const data = results.data;

        // Check if the required fields exist in the CSV data
        if (!data || !data.length || !data[0]['P Prod. (EMS) [kW]']) {
          this.errorMessage = 'El archivo CSV no es válido. Asegúrese de que contiene los datos necesarios.';
          return;
        }

        // Extract the relevant data for the chart
        const categories = data.map(row => row.date);
        const series1Data = data.map(row => row['P Prod. (EMS) [kW]'] / 1000); // Convert kW to MW

        // Emit the data to the parent component
        this.$emit('data-loaded', { categories, series1Data });
      },
      handleError(error) {
        this.errorMessage = 'Ocurrió un error al procesar el archivo CSV. Por favor, intente nuevamente.';
      },
    },
  };
  </script>

  <style>
  input[type="file"] {
    margin-bottom: 1rem;
  }
  </style>
