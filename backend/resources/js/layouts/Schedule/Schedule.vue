<template>
    <div class="flex justify-center items-center min-h-screen">
        <Card class="max-w-md w-full">
            <template #content>
                <div class="main mb-2">
                    <Button as="a" label="Wróć" href="/dashboard" rel="noopener" class="rounded-lg bg-gradient-to-br from-primary-400 to-primary-700 active:from-primary-700 active:to-primary-900 text-white border-none px-6 py-3 font-bold hover:ring-2 cursor-pointer ring-offset-2 ring-offset-surface-0 dark:ring-offset-surface-900 ring-primary transition-all" />
                </div>
                <div class="main mb-2">
                    <h2>Harmonogram Treningów</h2>
                </div>
                <hr>
                <div class="main mb-2">
                    <VDatePicker v-model="date" mode="dateTime" :select-attribute="selectAttribute"/>
                </div>
                <div class="main mb-2">
                    <label for="trainingDay">Wybierz dzień treningowy:</label>
                    <Select v-model="selectedTrainingDay" :options="plan.training_days"  optionLabel="day_name" placeholder="Wybierz jednostke treningową" checkmark :highlightOnSelect="false" class="w-full md:w-56" />
                </div>
                <div class="main mb-2">
                    {{ date }}
                    <Button label="Dodaj do harmonogramu" @click="addToSchedule"/>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const date = ref(new Date());
const selectAttribute = ref({ dot: true });
const plan = ref({});
const planId = ref(null);
const selectedTrainingDay = ref(null);

const formatDate = (date) => {
    const d = new Date(date);
    return d.getFullYear() + '-' +
           ('0' + (d.getMonth() + 1)).slice(-2) + '-' +
           ('0' + d.getDate()).slice(-2) + ' ' +
           ('0' + d.getHours()).slice(-2) + ':' +
           ('0' + d.getMinutes()).slice(-2) + ':' +
           ('0' + d.getSeconds()).slice(-2);
}

const addToSchedule = async () => {
    try {
        const formattedDate = formatDate(date.value);
        const response = await axios.post('/training-schedule', {
            training_day_id: selectedTrainingDay.value.id,
            scheduled_date: formattedDate,
        });

        alert(response.data.message);
    } catch (error) {
        if (error.response && error.response.status === 422) {
            alert(error.response.data.message);
        } else {
            console.error('Error adding to schedule:', error);
        }
    }
};



const fetchPlanDetails = async () => {
    try {
        const currentPlan = await axios.get('/user/get-default-plan');
        planId.value = currentPlan.data.id;
        
        const response = await axios.get(`/training-plan-details-data/${planId.value}`);
        plan.value = response.data;
    } catch (error) {
        console.error('Error fetching plan details:', error);
    }
};

onMounted(() => {
    fetchPlanDetails();
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
