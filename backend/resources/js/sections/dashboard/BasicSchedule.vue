<template>
    <div class="card" v-for="user in loggedUser" :key="user.id">
        <Toast />
        <Panel toggleable header="Harmonogram treningów">
            <template #footer>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <Button icon="pi pi-user" rounded text></Button>
                        <Button icon="pi pi-bookmark" severity="secondary" rounded text></Button>
                    </div>
                </div>
            </template>
            <template #icons>
                <Button icon="pi pi-cog" severity="secondary" rounded text @click="toggle" />
                <Menu ref="menu" id="config_menu" :model="items" popup />
            </template>
            <div class="p-4">
                <ul class="list-disc pl-5">
                    <li v-for="schedule in schedules" :key="schedule.id" class="mb-4">
                        <h4 class="font-semibold">Trening Plan: {{ schedule.training_plan.name }}</h4>
                        <p><strong>Opis:</strong> {{ schedule.training_plan.desc }}</p>
                        <p><strong>Typ:</strong> {{ schedule.type === 'daily' ? 'Codzienny' : 'Specyficzny' }}</p>
                        <p><strong>Data:</strong> {{ schedule.specific_date || 'Brak' }}</p>
                        <p><strong>Dzień tygodnia:</strong> {{ translateDayOfWeek(schedule.day_of_week) || 'Brak' }}</p>
                        <p><strong>Godzina:</strong> {{ schedule.start_time }}</p>
                    </li>
                </ul>
            </div>
        </Panel>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const loggedUser = ref([]);
const schedules = ref([]);

const dayOfWeekMap = {
    monday: 'Poniedziałek',
    tuesday: 'Wtorek',
    wednesday: 'Środa',
    thursday: 'Czwartek',
    friday: 'Piątek',
    saturday: 'Sobota',
    sunday: 'Niedziela'
};

const fetchUser = async () => {
    try {
        const response = await axios.get('/fetch-user-data');
        loggedUser.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

const fetchSchedules = async () => {
    try {
        const response = await axios.get(`/schedules/${loggedUser.value.id}`);
        schedules.value = response.data;
    } catch (error) {
        console.error('Error fetching schedules:', error);
    }
};

const translateDayOfWeek = (day) => {
    return dayOfWeekMap[day.toLowerCase()] || day;
};

onMounted(() => {
    fetchUser();
    fetchSchedules();
});
</script>


<style scoped>
.p-panel {
    background-color: rgb(34, 146, 79);
}

ul {
    list-style-type: disc;
    padding-left: 20px;
}

li {
    margin-bottom: 10px;
}
</style>
