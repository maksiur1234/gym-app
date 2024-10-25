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
            <h1 class="mt-2">Statystyki treningowe</h1>
            <p>Ilość sesji treningowych: {{ stats.totalSessions }}</p>
            <p>Ilość wykonanych ćwiczeń: {{ stats.totalExercises }}</p>
        </Panel>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useApiStore } from '../../stores/apiStore';
import axios from 'axios';

const stats = ref([]);

const fetchUserStats = async () => {
    try {
        const response = await axios.get('/user/stats');
        stats.value = response.data.stats.basic; 
        console.log(response.data.stats.basic);
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
