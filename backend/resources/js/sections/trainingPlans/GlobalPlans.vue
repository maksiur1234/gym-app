<template>
    <div class="flex flex-wrap gap-4 p-2 m-2" v-if="plans.length">
        <Card v-for="plan in plans" :key="plan.id" style="width: 25rem; overflow: hidden">
            <template #header>
                <div class="flex justify-center mt-4">
                    {{ plan.name }}
                </div>
            </template>
            <template #title>{{ plan.desc }}</template>
            <template #subtitle>{{ plan.price }} PLN</template>
            <template #content>
                <p class="m-0">
                    {{ plan.id }}
                </p>
            </template>
            <template #footer>
                <Button as="a" @click="checkout(plan.price, plan.id, plan.name, plan.desc, plan.created_by)" label="Kup plan" rel="noopener" class="mr-2" severity="primary" />
            </template>
        </Card>
    </div>
    <div v-else>
        <p>Brak planow</p>
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
