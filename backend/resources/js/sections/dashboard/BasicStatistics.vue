<template>
    <div class="card rounded-lg shadow-lg max-w-lg mx-auto">
        <Toast />
        
        <Panel toggleable header="Podstawowe statystyki" class="mb-4" v-if="apiStore.user">
            <template #icons>
                <Button icon="pi pi-cog" severity="secondary" rounded text @click="toggle" />
                <Menu ref="menu" id="config_menu" :model="items" popup />
            </template>
            
            <div class="text-gray-400">
                <h1 class="mt-2 mb-4 text-xl font-semibold text-gray-200">Dane uzytkownika</h1>

                <div class="flex items-center mb-2">
                    <i class="pi pi-calendar text-white mr-2"></i>
                    <p class="m-0 font-bold">Wiek: <span>{{ apiStore.user.age }}</span></p>
                </div>
                <div class="flex items-center mb-2">
                    <i class="pi pi-user text-green-500 mr-2"></i>
                    <p class="m-0 font-bold">Waga: <span>{{ apiStore.user.weight }} kg</span></p>
                </div>
                <div class="flex items-center mb-2">
                    <i class="pi pi-chart-bar text-blue-500 mr-2"></i>
                    <p class="m-0 font-bold">Wzrost: <span>{{ apiStore.user.height }} cm</span></p>
                </div>
                <div class="flex items-center">
                    <i class="pi pi-database text-red-500 mr-2"></i>
                    <p class="m-0 font-bold">Staż treningowy: <span>{{ apiStore.user.training_intership }} lat</span></p>
                </div>
            </div>
            
            <h1 class="mt-6 mb-4 text-xl font-semibold text-gray-200">Statystyki treningowe</h1>
            <div class="text-gray-400">
                <div class="flex items-center mb-2">
                    <i class="pi pi-clock mr-2"></i>
                    <p class="m-0 font-bold">Ilość sesji treningowych: <span>{{ stats.totalSessions }}</span></p>
                </div>
                <div class="flex items-center">
                    <i class="pi pi-dumbbell mr-2"></i>
                    <p class="m-0 font-bold">Ilość wykonanych ćwiczeń: <span>{{ stats.totalExercises }}</span></p>
                </div>
            </div>
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

<style scoped>
</style>
