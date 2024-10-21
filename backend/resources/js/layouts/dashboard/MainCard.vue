<template>
    <div class="flex justify-center items-center min-h-screen">
        <Card class="max-w-md w-full">
            <template #title>Hej rozpocznij trening klikając w przycisk!</template>
            <template #content>
                <div class="main mb-2">
                    <Button
                        v-if="currentPlanId"
                        as="a"
                        :label="'Wyświetl aktualny plan treningowy'"
                        :href="`/training-plan-details/${currentPlanId}`"
                        target="_blank"
                        rel="noopener"
                        class="rounded-lg bg-gradient-to-br from-primary-400 to-primary-700 active:from-primary-700 active:to-primary-900 text-white border-none px-6 py-3 font-bold hover:ring-2 cursor-pointer ring-offset-2 ring-offset-surface-0 dark:ring-offset-surface-900 ring-primary transition-all"
                    />
                    <Button
                        @click="toggleTraining"
                        :label="isTrainingActive ? 'Anuluj trening' : 'Rozpocznij trening'"
                        class="ml-2 mb-4"
                    />
                    <CurrentTrainingCard v-if="isTrainingActive"/>
                </div>
                <div class="mb-2">
                    <BasicInfo />
                </div>
                <div class="mb-2">
                    <BasicSchedule />
                </div>
                <div class="mb-2">
                    <BasicStatistics />
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import BasicInfo from '../../sections/dashboard/BasicInfo.vue';
import BasicSchedule from '../../sections/dashboard/BasicSchedule.vue';
import BasicStatistics from '../../sections/dashboard/BasicStatistics.vue';
import CurrentTrainingCard from '../../sections/training/CurrentTrainingCard.vue';

import { ref, onMounted } from 'vue';
import axios from 'axios';

const isTrainingActive = ref(false);
const currentPlanId = ref(null);

const fetchCurrentPlan = async () => {
    try {
        const response = await axios.get('/user/get-default-plan');
        currentPlanId.value = response.data.id;
    } catch (error) {
        console.error('Error fetching current training plan:', error);
    }
};

const toggleTraining = async () => {
    if (isTrainingActive.value) {
        try {
            await axios.post('/workout/end', {
                session_id: currentSessionId.value,
            });
            isTrainingActive.value = false;
        } catch (error) {
            console.error('Error ending workout session:', error);
        }
    } else {
        try {
            const response = await axios.post('/workout/start', {
                training_plan_id: currentPlanId.value,
            });
            currentSessionId.value = response.data.session_id;
            isTrainingActive.value = true;
        } catch (error) {
            console.error('Error starting workout session:', error);
        }
    }
};

const currentSessionId = ref(null);

onMounted(() => {
    fetchCurrentPlan();
});
</script>

<style scoped>
.max-w-md {
    max-width: 88rem;
}

.main {
    min-width: 80rem;
}
</style>
