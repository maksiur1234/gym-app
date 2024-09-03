<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const plans = ref([]); // Initialize as an empty array

const fetchReadyPlans = async () => {
    try {
        const response = await axios.get('/ready-training-plans-data');
        plans.value = response.data.data; 
    } catch (error) {
        console.error('Error fetching plans:', error);
    }
};

onMounted(() => {
    fetchReadyPlans();
});
</script>

<template>
    <div v-if="plans.length">
        <div v-for="plan in plans" :key="plan.id" class="plan-item">
            <h2>{{ plan.name }}</h2>
            <p>{{ plan.desc }}</p>
        </div>
    </div>
    <p v-else>Loading plans...</p>
</template>

