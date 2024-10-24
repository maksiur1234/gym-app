<template>
    <div class="flex justify-center items-center min-h-screen">
        <Card class="max-w-md w-full shadow-lg">
            <template #content>
                <div class="main mb-4 text-left">
                    <Button as="a" label="Wróć" href="/dashboard" rel="noopener" class="rounded-lg bg-gradient-to-br from-primary-400 to-primary-700 text-white px-6 py-3 font-bold transition-all hover:bg-opacity-90" />
                    
                <label for="darkmode" class="flex items-center mt-4">
                    <input id="darkmode" type="checkbox" v-model="isDark" class="mr-2" />
                    <span class="text-gray-700 dark:text-gray-300">Tryb nocny</span>
                </label>
                </div>
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white">Harmonogram Treningów</h2>
                <hr class="border-gray-300 mb-4" />

                <div class="main mb-4">
                    <label for="trainingDay" class="block text-gray-700 dark:text-gray-300 mb-2">Wybierz dzień treningowy:</label>
                    <Select 
                        v-model="selectedTrainingDay" 
                        :options="plan.training_days"  
                        optionLabel="day_name" 
                        placeholder="Wybierz jednostkę treningową" 
                        checkmark 
                        :highlightOnSelect="false" 
                        class="w-full md:w-56"
                    />
                    <label for="trainingDay" class="block text-gray-700 dark:text-gray-300 mb-2">Jeżeli chcesz dodać ręcznie jednostkę treningową do dnia, wybierz konkretną jednostkę i dodaj do harmonogramu. Jeżeli chcesz dodać wiele jednostek treningowych jednego dnia tygodnia, zaznacz pole poniżej:</label>
                    <Checkbox v-model="moreDays" inputId="moreDays" name="moreDays" value="moreDays" />
                    <label for="moreDays" class="ml-2"> Dodaj wiele jednostek jednego dnia tygodnia </label>
                </div>
                
                <div class="main mb-4 flex justify-center">
                    <VDatePicker 
                        :columns="columns" 
                        v-model="date" 
                        color="green" 
                        mode="dateTime" 
                        :select-attribute="selectAttribute" 
                        :attributes='attributes' 
                        :is-dark="isDark"
                        class="w-full"
                    />
                </div>
                <div v-if="moreDays" class="main mb-4">
                    <label for="numberOfUnits" class="block text-gray-700 dark:text-gray-300 mb-2">Ilość jednostek do dodania:</label>
                    <InputNumber v-model="numberOfUnits" min="1" class="w-full md:w-56" />
                </div>

                <div class="main mb-4 text-center">
                    <Button 
                        label="Dodaj do harmonogramu" 
                        @click="addToSchedule" 
                        class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition-all"
                    />
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useScreens } from 'vue-screen-utils'
import Checkbox from 'primevue/checkbox';

const { mapCurrent } = useScreens({ xs: '0px', sm: '640px', md: '768px', lg: '1024px' });
const columns = mapCurrent({ lg: 2 }, 1);

const date = ref(new Date());
const selectAttribute = ref({ dot: true });
const plan = ref({});
const planId = ref(null);
const selectedTrainingDay = ref(null);
const numberOfUnits = ref(1);
const schedule = ref();
const isDark = ref(true);
const moreDays = ref(false);

const getScheduleData = async () => {
    try {
        const response = await axios.get('/schedule-data');
        schedule.value = response.data;

        attributes.value = schedule.value.map(item => {
            const trainingDay = plan.value && plan.value.training_days 
                ? plan.value.training_days.find(day => day.id === item.training_day_id) 
                : null;

            const trainingDayName = trainingDay ? trainingDay.day_name : 'Jednostka treningowa';

            return {
                highlight: true,
                dates: [new Date(item.scheduled_date)],
                dot: {
                    color: 'blue', 
                },
                popover: {
                    label: trainingDayName, 
                }
            };
        });

    } catch (error) {
        console.error(error);
    }
};

const attributes = ref([]);

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
        const selectedDay = new Date(date.value);

        if (moreDays.value) {
            for (let i = 0; i < numberOfUnits.value; i++) {

                const scheduledDate = new Date(selectedDay);
                scheduledDate.setDate(selectedDay.getDate() + (i * 7)); 

                const formattedDate = formatDate(scheduledDate);

                const existingSchedule = schedule.value.find(item => {
                    const scheduledDateISO = new Date(item.scheduled_date).toISOString().split('T')[0];
                    return item.training_day_id === selectedTrainingDay.value.id && scheduledDateISO === formattedDate.split(' ')[0];
                });

                if (existingSchedule) {
                    alert(`Jednostka treningowa dla ${selectedTrainingDay.value.day_name} w dniu ${formattedDate.split(' ')[0]} została już dodana.`);
                    continue; 
                }

                await axios.post('/training-schedule', {
                    training_day_id: selectedTrainingDay.value.id,
                    scheduled_date: formattedDate,
                });
            }
            alert('Jednostki treningowe zostały dodane do harmonogramu.');
        } else {
            const formattedDate = formatDate(selectedDay);

            const existingSchedule = schedule.value.find(item => {
                const scheduledDateISO = new Date(item.scheduled_date).toISOString().split('T')[0];
                return item.training_day_id === selectedTrainingDay.value.id && scheduledDateISO === formattedDate.split(' ')[0];
            });

            if (existingSchedule) {
                alert('Ten dzień treningowy został już dodany do harmonogramu.');
                return; 
            }

            const response = await axios.post('/training-schedule', {
                training_day_id: selectedTrainingDay.value.id,
                scheduled_date: formattedDate,
            });

            alert(response.data.message);
        }
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
        const currentPlan = sessionStorage.getItem('defaultPlan');

        if (currentPlan) {
            const planData = JSON.parse(currentPlan);
            planId.value = planData.id;  

            const response = await axios.get(`/training-plan-details-data/${planId.value}`);
            plan.value = response.data;
        } else {
            console.error('Nie znaleziono planu w sessionStorage.');
        }
    } catch (error) {
        console.error('Error fetching plan details:', error);
    }
};


onMounted(() => {
    fetchPlanDetails();
    getScheduleData();
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
