<template>
    <div>
        <table class="recap-table">
            <thead>
                <tr>
                    <th>Term</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in recapData" :key="index">
                    <td>{{ item.term }}</td>
                    <td>{{ item.value }}</td>
                </tr>
            </tbody>
        </table>
        <p v-if="loading">Cargando datos...</p>
        <p v-if="error" style="color: red;">Error al obtener datos.</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            recapData: [],
            loading: true,
            error: false,
        };
    },
    mounted() {
        this.fetchRecapData();
    },
    methods: {
        async fetchRecapData() {
            try {
                const response = await fetch('/api/recap/data');
                if (!response.ok) {
                    throw new Error('Error al obtener datos');
                }
                const data = await response.json();

                // Convertir el objeto JSON en un array de términos y valores
                this.recapData = Object.entries(data).map(([term, value]) => ({
                    term,
                    value: typeof value === 'string' ? value : JSON.stringify(value),
                }));

                this.loading = false;
            } catch (error) {
                this.error = true;
            } finally {
                setTimeout(() => {
                    if (this.loading) {
                        this.error = true;
                    }
                }, 30000); // 30 segundos
            }
        },
    },
};
</script>

<style scoped>
.recap-table {
    width: 100%;
    border-collapse: collapse;
    margin-left: 20px;
    margin-block: 20px;
}

.recap-table th,
.recap-table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.recap-table th {
    background-color: #f5f5f5;
}

.loading-message,
.error-message {
    font-weight: bold;
    margin-top: 10px;
}

.error-message {
    color: red;
}
</style>
