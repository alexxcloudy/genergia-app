<template>
    <div>
        <input type="file" @change="handleFileUpload" accept=".csv">
        <div v-if="file">
            <i class="fas fa-file-csv"></i>
            <p>{{ file.name }}</p>
            <PrimaryButton @click="checkFile">Leer fichero</PrimaryButton>
            <PrimaryButton @click="submitFile">Enviar a la API</PrimaryButton>
        </div>

        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
import PrimaryButton from '@/Components/PrimaryButton.vue';

export default {
    components: {

        PrimaryButton,

    },
    data() {
        return {
            file: null,
            message: ''
        };
    },
    methods: {
    handleFileUpload(event) {
      const uploadedFile = event.target.files[0];
      if (uploadedFile) {
        this.file = uploadedFile;
      }
    },
    checkFile() {
      if (this.file) {
        this.message = 'File is ready to be submitted';
      } else {
        this.message = 'No file selected';
      }
    },
    async submitFile() {
      if (!this.file) {
        this.message = 'No file to submit';
        return;
      }

      let formData = new FormData();
      formData.append('file', this.file);

      try {
        let response = await fetch("/api/upload-csv", {
            method: "POST",
            body: formData,
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        let result = await response.json();
        this.message = result.message;
      } catch (error) {
        this.message = "Error uploading file.";
      }
    }
  }
};
</script>

<style>
.fas.fa-file-csv {
  font-size: 48px;
}
</style>
