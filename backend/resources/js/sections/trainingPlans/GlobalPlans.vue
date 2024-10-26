<template>
    <div class="flex flex-wrap gap-4 p-4" v-if="plans.length">
        <Card 
            v-for="plan in plans" 
            :key="plan.id" 
            style="width: 20rem; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px;"
            class="card transition-transform transform hover:scale-105"
        >
            <template #header>
                <div class="flex justify-center mt-4 text-xl font-semibold">
                    {{ plan.name }}
                </div>
            </template>
            <template #title>
                <div class="text-gray-600">
                    {{ plan.desc }}
                </div>
            </template>
            <template #subtitle>
                <div class="font-bold text-lg text-blue-600">
                    {{ plan.price }} PLN
                </div>
            </template>
            <template #content>
                <p class="m-0 text-gray-500">
                    ID Planu: {{ plan.id }}
                </p>
            </template>
            <template #footer>
                <Button 
                    as="a" 
                    @click="checkout(plan.price, plan.id, plan.name, plan.desc, plan.created_by)" 
                    label="Kup plan" 
                    rel="noopener" 
                    class="mr-2" 
                    severity="primary" 
                    style="width: 100%;"
                />
            </template>
        </Card>
    </div>
    <div v-else>
        <p class="text-center text-gray-500">Brak planów</p>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const plans = ref([]);

const fetchReadyPlans = async () => {
    try {
        const response = await axios.get('/ready-training-plans-data');
        plans.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

const checkout = async (price, id, name, desc, created_by) => {
    try {
        window.location.href = `/stripe?price=${price}&planId=${id}&name=${name}&desc=${desc}&created_by=${created_by}`;
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    fetchReadyPlans();
});
</script>

<style scoped>
.card {
    transition: transform 0.2s; 
}

.card:hover {
    transform: scale(1.05); 
}
</style>
