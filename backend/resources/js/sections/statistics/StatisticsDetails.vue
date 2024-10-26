<template>
    <div class="flex flex-wrap gap-4 p-2 m-2">
        <Card>
            <template #header>
                <div class="flex justify-center mt-4 text-lg font-semibold">
                    Statystyki treningowe
                </div>
            </template>
            <template #title>
                Podstawowe informacje
            </template>
            <template #content>
                <div class="flex flex-col gap-2">
                    <p>Wiek: <strong>{{ apiStore.user.age }}</strong></p>
                    <p>Waga: <strong>{{ apiStore.user.weight }}</strong></p>
                    <p>Wzrost: <strong>{{ apiStore.user.height }}</strong></p>
                    <p>Staż treningowy: <strong>{{ apiStore.user.training_intership }} lat</strong></p>
                </div>
            </template>
        </Card>

        <Card>
            <template #header>
                <div class="flex justify-center mt-4 text-lg font-semibold">
                    Statystyki sesji
                </div>
            </template>
            <template #title>
                Sesje treningowe
            </template>
            <template #content>
                <div class="flex flex-col gap-2">
                    <p>Całkowita liczba sesji: <strong>{{ stats.basic.totalSessions }}</strong></p>
                    <p>Ukończone sesje: <strong>{{ stats.basic.completedSessions }}</strong></p>
                </div>
            </template>
        </Card>

        <Card>
            <template #header>
                <div class="flex justify-center mt-4 text-lg font-semibold">
                    Statystyki ćwiczeń
                </div>
            </template>
            <template #title>
                Ćwiczenia
            </template>
            <template #content>
                <div class="flex flex-col gap-2">
                    <p>Całkowita liczba ćwiczeń: <strong>{{ stats.basic.totalExercises }}</strong></p>
                    <p>Całkowita liczba serii: <strong>{{ stats.totalSets }}</strong></p>
                    <p>Całkowita liczba powtórzeń: <strong>{{ stats.totalReps }}</strong></p>
                </div>
            </template>
        </Card>

        <Card>
            <template #header>
                <div class="flex justify-center mt-4 text-lg font-semibold">
                    Szczegóły ćwiczeń
                </div>
            </template>
            <template #title>
                Szczegóły
            </template>
            <template #content>
                <ul class="flex flex-col gap-2">
                    <li v-for="(exercise, index) in stats.exerciseDetails" :key="index" class="border p-2 rounded">
                        <strong>{{ exercise.exercise_name }}</strong> - 
                        Całkowite serie: <strong>{{ exercise.total_sets }}</strong>, 
                        Całkowite powtórzenia: <strong>{{ exercise.total_reps }}</strong>
                    </li>
                </ul>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useApiStore } from '../../stores/apiStore';
import axios from 'axios';

const stats = ref({
    basic: {
        totalSessions: 0,
        totalExercises: 0,
    },
    totalSets: 0,
    totalReps: 0,
    completedSessions: 0,
    exerciseDetails: [],
});

const fetchUserStats = async () => {
    try {
        const response = await axios.get('/user/stats');
        stats.value = response.data.stats;
    } catch (error) {
        console.error('Błąd podczas pobierania statystyk:', error);
    }
};

const apiStore = useApiStore();

onMounted(() => {
    apiStore.fetchUserData();
    fetchUserStats();
});
</script>
