<template>

    <MainMenu />

    <Head title="SendCsv" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                SendCsv
            </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">Bienvenido: {{ $page.props.auth.user.name }}</div>
                    <div class="flex items-center gap-4">
                        <UploadCsv></UploadCsv>
                    </div>
                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MainMenu from "@/Pages/MainMenu.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head } from "@inertiajs/vue3";
import Recap from '@/Components/Recap.vue'; // Ajusta la ruta según tu estructura de carpetas
import UploadCsv from '@/Components/UploadCsv.vue';


export default {
    components: {
        apexchart: VueApexCharts,
        AuthenticatedLayout,
        Head,
        PrimaryButton,
        MainMenu,
        Recap, UploadCsv
    },
    ata() {
    return {
      file: null,
      message: ""
    };
  },
  methods: {
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    checkFile() {
      if (this.file) {
        this.message = "File loaded successfully.";
      } else {
        this.message = "No file loaded.";
      }
    },
    async submitFile() {
      if (!this.file) {
        this.message = "Please load a file first.";
        return;
      }

      let formData = new FormData();
      formData.append("file", this.file);

      try {
        let response = await fetch("http://localhost/api/upload-csv", {
          method: "POST",
          body: formData,
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
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
.file-icon {
  /* Add your styles for the file icon here */
}
#app {
    text-align: center;
}
</style>

