<template>
      <!-- <MainMenu /> -->


    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Bienvenido: {{ $page.props.auth.user.name }}
                    </div>
                    <div class="flex items-center gap-4">
                        <apexchart :key="chartKey" :type="chartOptions.chart.type" width="1050" :options="chartOptions"
                            :series="series"></apexchart>
                        <PrimaryButton @click="updateChart">Actualizar Datos</PrimaryButton>
                    </div>
                </div>
                <div class="content">
                    <csv-loader @data-loaded="handleDataLoaded"></csv-loader>
                    <div v-if="csvErrorMessage" class="text-red-500 mt-2">{{ csvErrorMessage }}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import VueApexCharts from 'vue3-apexcharts';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MainMenu from '@/Pages/MainMenu.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head } from '@inertiajs/vue3';
import CsvLoader from '@/Components/CsvLoader.vue';

export default {
    components: {
        apexchart: VueApexCharts,
        AuthenticatedLayout,
        Head,
        PrimaryButton,
        MainMenu,
        CsvLoader,
    },
    data() {
        return {
            chartKey: 0,
            series: [
                {
                    name: 'P Prod. (EMS) [kW]',
                    type: 'column',
                    data: [], // Initial data will be updated from API
                },
                {
                    name: 'P Prod. to Dumping (EMS) [kW]',
                    type: 'column',
                    data: [], // Initial data will be updated from API
                },
                {
                    name: 'P Prod. to Grid (EMS) [kW]',
                    type: 'column',
                    data: [], // Initial data will be updated from API
                },
                {
                    name: 'P Prod. to Bat. (EMS) [kW]',
                    type: 'column',
                    data: [], // Initial data will be updated from API
                },
                {
                    name: 'P Bat. to Grid (EMS) [kW]',
                    type: 'column',
                    data: [], // Initial data will be updated from API
                },
            ],
            chartOptions: {
                chart: {
                    height: 350,
                    type: 'line',
                },
                stroke: {
                    width: [0, 4],
                },
                title: {
                    text: 'Producción Horaria (EMS)',
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [0],
                },
                labels: [], // Initial labels will be updated from API
                xaxis: {
                    type: 'datetime',
                },
                yaxis: [
                    {
                        title: {
                            text: 'Potencia (MW)',
                        },
                    },
                ],
            },
            csvErrorMessage: '',
        };
    },
    methods: {
        updateChart() {
            // This method can be used to update chart options or trigger a redraw if needed
            this.chartKey += 1;
        },
        handleDataLoaded({ categories, series1Data, series2Data, series3Data, series4Data, series5Data }) {
            // Update series data and labels from CSV
            this.series = [
                {
                    ...this.series[0],
                    data: series1Data,
                },
                {
                    ...this.series[1],
                    data: series2Data,
                },
                {
                    ...this.series[2],
                    data: series3Data,
                },
                {
                    ...this.series[3],
                    data: series4Data,
                },
                {
                    ...this.series[4],
                    data: series5Data,
                },
            ];
            this.chartOptions.labels = categories;
            this.chartKey += 1; // Trigger chart redraw
            this.csvErrorMessage = ''; // Clear error message
        },
        async fetchData() {
            try {
                const response = await fetch('/api/data');
                const data = await response.json();

                const categories = data.map(row => row['date']);
                const series1Data = data.map(row => row['P Prod. (EMS) [kW]'] ); // Convert kW to MW
                const series2Data = data.map(row => row['P Prod. to Dumping (EMS) [kW]']);
                const series3Data = data.map(row => row['P Prod. to Grid (EMS) [kW]']);
                const series4Data = data.map(row => row['P Prod. to Bat. (EMS) [kW]']);
                const series5Data = data.map(row => row['P Bat. to Grid (EMS) [kW]']);

                this.handleDataLoaded({ categories, series1Data, series2Data, series3Data, series4Data, series5Data  });
            } catch (error) {
                this.csvErrorMessage = 'Error al cargar datos de la API';
            }
        },
    },
    mounted() {
        this.fetchData(); // Fetch data from API when the component is mounted
    },
};
</script>

<style>
#app {
    text-align: center;
}

.content {
    margin-top: 1rem;
}
</style>
