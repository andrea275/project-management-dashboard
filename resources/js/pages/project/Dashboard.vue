<template>
    <div class="p-12">
        <div class="border border-gray-300 shadow-md rounded pt-6 pb-8 px-8 w-full h-full md:w-1/2 md:h-1/2 xl:w-1/3 xl:h-1/3">
            <div class="w-full h-full">
                <h3 class="text-xl text-gray-500 text-center mb-4">Tasks Report</h3>
                <canvas id="tasksChart"></canvas>
            </div>
        </div>
    </div>
</template>

<script>
import {
    Chart,
    ArcElement,
    PieController,
    Legend,
    Title,
    Tooltip,
    SubTitle
} from "chart.js";

Chart.register(
    ArcElement,
    PieController,
    Legend,
    Title,
    Tooltip,
    SubTitle
);

export default {
    name: "Dashboard",
    props: {
        projectSlug: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            chart: null,
            colors: {
                gray: '#6b7280',
                yellow: '#eab308',
                orange: '#f97316',
                amber: '#f59e0b',
                red: '#ef4444',
                blue: '#3b82f6',
                green: '#22c55e',
                purple: '#a855f7',
                pink: '#ec4899'
            }
        }
    },
    mounted() {
        this.setChart();
    },
    methods: {
        async setChart() {
            const {data} = await axios.get(`/api/project/${this.projectSlug}/statusWithTaskCount`);

            const labels = data.map(status => status.name);
            const colors = data.map(status => this.colors[status.color]);
            const tasks = data.map(status => status.tasks);

            if (this.chart) {
                this.chart.destroy();
            }

            const ctx = document.getElementById('tasksChart').getContext('2d');

            this.chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Tasks Report',
                            data: tasks,
                            backgroundColor: colors,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                },
            });
        }
    }
}
</script>
