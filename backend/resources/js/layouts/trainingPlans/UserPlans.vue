<template>
    <div class="card">
        <DataView :value="plans">
            <template #list="slotProps">
                <div class="flex flex-col">
                    <div v-for="(item, index) in slotProps.items" :key="index">
                        <div class="flex flex-col sm:flex-row sm:items-center p-6 gap-4" :class="{ 'border-t border-surface-200 dark:border-surface-700': index !== 0 }">
                            <div class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                <div class="flex flex-row md:flex-col justify-between items-start gap-2">
                                    <div>
                                        <span class="font-medium text-surface-500 dark:text-surface-400 text-sm">{{ item.category }}</span>
                                        <div class="text-lg font-medium mt-2">{{ item.name }}</div>
                                    </div>
                                </div>
                                <div class="flex flex-col md:items-end gap-8">
                                    <span class="text-lg font-medium mt-2">{{ item.desc }}</span>
                                    <div class="flex flex-row-reverse md:flex-row gap-2">
                                        <Button icon="pi pi-heart" outlined label="Ustaw jako domyślny" @click="setAsDefault(item)"></Button>
                                        <Button label="Zobacz szczegóły" class="flex-auto md:flex-initial whitespace-nowrap" as="a" :href="`/training-plan-details/${item.id}`"></Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </DataView>
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

const setAsDefault = async (plan) => {
    try {
        await axios.post('/user/set-default-plan', { training_plan_id: plan.id });
        
        localStorage.setItem('defaultPlan', JSON.stringify(plan));

        alert('Domyślny plan treningowy został zaktualizowany.');
    } catch (error) {
        console.error('Error setting default plan:', error);
        alert('Wystąpił błąd podczas aktualizacji domyślnego planu.');
    }
};

onMounted(() => {
    fetchUserPlans();
});
</script>

<style scoped>
</style>
