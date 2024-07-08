<template>

<MainMenu />
    <Head title="Organizations" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Organizations
            </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">Bienvenido:  {{ $page.props.auth.user.name }}</div>
                    <div class="flex items-center gap-4">
                        <apexchart :key="chartKey" :type="chartOptions.chart.type" width="550" :options="chartOptions"
                            :series="series">
                        </apexchart>
                        <PrimaryButton @click="updateChart">Actualizar Datos</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">Bienvenido:  {{ $page.props.auth.user.name }}</div>
                    <div class="flex items-center gap-4">
                        <apexchart :key="chartKey" :type="chartOptions.chart.type" width="550" :options="chartOptions"
                            :series="series">
                        </apexchart>
                        <PrimaryButton @click="updateChart">Actualizar Datos</PrimaryButton>
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

export default {
    components: {
        apexchart: VueApexCharts,
        AuthenticatedLayout,
        Head,
        PrimaryButton,
        MainMenu,
    },
    data() {
        return {
            chartKey: 0, // Clave para forzar la recreación del componente
            series: [
                {
                    name: "Website Blog",
                    type: "column",
                    data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160],
                },
                {
                    name: "Social Media",
                    type: "line",
                    data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16],
                },
            ],
            chartOptions: {
                chart: {
                    height: 350,
                    type: "line",
                },
                stroke: {
                    width: [0, 4],
                },
                title: {
                    text: "Traffic Sources",
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [1],
                },
                labels: [
                    "01 Jan 2001",
                    "02 Jan 2001",
                    "03 Jan 2001",
                    "04 Jan 2001",
                    "05 Jan 2001",
                    "06 Jan 2001",
                    "07 Jan 2001",
                    "08 Jan 2001",
                    "09 Jan 2001",
                    "10 Jan 2001",
                    "11 Jan 2001",
                    "12 Jan 2001",
                ],
                xaxis: {
                    type: "datetime",
                },
                yaxis: [
                    {
                        title: {
                            text: "Website Blog",
                        },
                    },
                    {
                        opposite: true,
                        title: {
                            text: "Social Media",
                        },
                    },
                ],
            },
        };
    },
    methods: {
        updateChart() {
            const max = 90;
            const min = 20;

            // Generar nuevos datos para ambas series
            const newData1 = this.series[0].data.map(() => {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            });

            const newData2 = this.series[1].data.map(() => {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            });

            // Actualizar las series con los nuevos datos
            this.series = [
                {
                    ...this.series[0],
                    data: newData1,
                },
                {
                    ...this.series[1],
                    data: newData2,
                },
            ];

            // Cambiar el tipo de gráfico y actualizar la clave para forzar la recreación del componente
            this.chartOptions.chart.type =
                this.chartOptions.chart.type === "line" ? "bar" : "line";
            this.chartKey += 1;
        },
    },
};
</script>

<style>
#app {
    text-align: center;
}
</style>
