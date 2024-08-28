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
                    <vue-cal
                        :style="calendarStyle"
                        :events="events"
                        :time="time"
                        :week-start="1"
                        :locale="locale"
                    ></vue-cal>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';

const userId = ref(2);
const trainingPlanId = ref('');
const dayOfWeek = ref('');
const startTime = ref('');
const events = ref([]);
const calendarStyle = ref({});
const time = ref(new Date());
const locale = ref('en');

const formatEvents = (schedules) => {
    return schedules.map(schedule => {
        let startDate;
        if (schedule.specific_date) {
            startDate = new Date(schedule.specific_date + 'T' + schedule.start_time);
        } else {
            const dayMap = {
                'monday': 1,
                'tuesday': 2,
                'wednesday': 3,
                'thursday': 4,
                'friday': 5,
                'saturday': 6,
                'sunday': 7
            };
            const today = new Date();
            const diff = (dayMap[schedule.day_of_week] - today.getDay() + 7) % 7;
            startDate = new Date(today.setDate(today.getDate() + diff) + 'T' + schedule.start_time);
        }
        return {
            id: schedule.id,
            start: startDate,
            end: new Date(startDate.getTime() + 60 * 60 * 1000), // Zakładając, że każde wydarzenie trwa 1 godzinę
            title: `Training Plan: ${schedule.training_plan.name}`,
            description: schedule.training_plan.desc,
        };
    });
};

const fetchSchedules = async () => {
    try {
        const response = await axios.get(`/schedules/${userId.value}`);
        console.log('Fetched schedules:', response.data);
        events.value = formatEvents(response.data);
    } catch (error) {
        console.error('Error fetching schedules:', error);
    }
};

const addSchedule = async () => {
    try {
        await axios.post('/schedules', {
            user_id: userId.value,
            training_plan_id: trainingPlanId.value,
            day_of_week: dayOfWeek.value,
            start_time: startTime.value
        });
        fetchSchedules();
    } catch (error) {
        console.error('Error adding schedule:', error);
    }
};

const deleteSchedule = async (id) => {
    try {
        await axios.delete(`/api/schedules/${id}`);
        fetchSchedules();
    } catch (error) {
        console.error('Error deleting schedule:', error);
    }
};

onMounted(() => {
    fetchSchedules();
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
