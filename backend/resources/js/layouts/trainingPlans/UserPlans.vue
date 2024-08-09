<template>
    <div>
        <h1>Twoje Plany Treningowe</h1>
        <div v-if="loading">Ładowanie...</div>
        <div v-else-if="plans.length === 0">Brak planów treningowych.</div>
        <ul v-else>
            <li v-for="plan in plans" :key="plan.id">
                <h2>{{ plan.name }}</h2>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const plans = ref([]);
const loading = ref(true);

const fetchUserPlans = async () => {
    try {
        const response = await axios.get('/training-plans-data');
        plans.value = response.data;
    } catch (error) {
        console.error('Error fetching user plans:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchUserPlans();
});
</script>

<style scoped>
h1 {
    font-size: 24px;
    margin-bottom: 16px;
}

h2 {
    font-size: 20px;
    margin: 8px 0;
}

p {
    font-size: 16px;
}
</style>
