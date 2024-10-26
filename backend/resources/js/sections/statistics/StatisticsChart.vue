
<template>
    <div class="card">
        <Chart type="bar" :data="chartData" :options="chartOptions" class="h-[30rem]"  />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useApiStore } from "../../stores/apiStore";
import axios from "axios";

const apiStore = useApiStore();

const stats = ref({
    basic: {
        totalSessions: 0,
        totalExercises: 0,
        completedSessions: 0,
    },
    totalSets: 0,
    totalReps: 0,
    exerciseDetails: []
});

const fetchUserStats = async () => {
    try {
        const response = await axios.get('/user/stats');
        stats.value = response.data.stats;

        chartData.value = setChartData();
    } catch (error) {
        console.error('Błąd podczas pobierania statystyk:', error);
    }
};

onMounted(() => {
    apiStore.fetchUserData();
    fetchUserStats();
    chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref();

const setChartData = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const labels = stats.value.exerciseDetails.map(detail => detail.exercise_name);
    const dataReps =  stats.value.exerciseDetails.map(detail => parseInt(detail.total_reps));
    const dataSets = stats.value.exerciseDetails.map(detail => parseInt(detail.total_sets));

    return {
        labels,
        datasets: [
            {
                label: 'Ilość powtórzeń w ćwiczeniu',
                backgroundColor: documentStyle.getPropertyValue('--p-cyan-500'),
                borderColor: documentStyle.getPropertyValue('--p-cyan-500'),
                data: dataReps
            },
            {
                label: 'Ilość serii w ćwiczeniu',
                backgroundColor: documentStyle.getPropertyValue('--p-gray-500'),
                borderColor: documentStyle.getPropertyValue('--p-gray-500'),
                data: dataSets
            }
        ]
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--p-text-muted-color');
    const surfaceBorder = documentStyle.getPropertyValue('--p-content-border-color');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary,
                    font: {
                        weight: 500
                    }
                },
                grid: {
                    display: false,
                    drawBorder: false
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder,
                    drawBorder: false
                }
            }
        }
    };
}
</script>
