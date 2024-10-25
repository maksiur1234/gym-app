<template>
    <div class="card">
        <Toast />
        <Panel toggleable header="Podstawowe statystyki" v-if="apiStore.user">
            <template #icons>
                <Button icon="pi pi-cog" severity="secondary" rounded text @click="toggle" />
                <Menu ref="menu" id="config_menu" :model="items" popup />
            </template>
            <p class="m-0">
                <p>Wiek: {{ apiStore.user.age }}</p>
                <p>Waga: {{ apiStore.user.weight }}</p>
                <p>Wzrost: {{ apiStore.user.height }}</p>
                <p>Staż treningowy: {{ apiStore.user.training_intership }} lat</p>
            </p>
            <h1>Statystyki treningowe</h1>
            <p>Ilość wszystkich serii: {{ stats.totalSets }}</p>
            <p>Ilość wszystkich powtórzeń: {{ stats.totalReps }}</p>
            <p>Ilość zrealizowanych treningów: {{ stats.totalSessions }}</p>
            <p>Ilość ćwiczeń: {{ stats.totalExercises }}</p>
            <h2>Szczegóły ćwiczeń</h2>
            <ul>
                <li v-for="exercise in stats.exerciseDetails" :key="exercise.exercise_name">
                    {{ exercise.exercise_name }}: {{ exercise.total_sets }} serie, {{ exercise.total_reps }} powtórzeń
                </li>
            </ul>
        </Panel>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useApiStore } from '../../stores/apiStore';
import axios from 'axios';

const stats = ref({});

const fetchUserStats = async () => {
    const response = await axios.get('/user/stats');
    stats.value = response.data;
    console.log(stats.value);
};

const apiStore = useApiStore();

onMounted(() => {
    apiStore.fetchUserData();
    fetchUserStats();
});
</script>
