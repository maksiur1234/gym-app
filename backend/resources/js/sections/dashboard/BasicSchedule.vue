
<template>
    <div class="card">
        <Toast />
        <Panel toggleable header="Harmonogram">
            <template #icons>
                <Button icon="pi pi-cog" severity="secondary" rounded text @click="toggle" />
                <Menu ref="menu" id="config_menu" :model="items" popup />
            </template>
            <div class="flex justify-center">
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
        </Panel>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useScreens } from 'vue-screen-utils'
import { useApiStore } from '../../stores/apiStore';

const { mapCurrent } = useScreens({ xs: '0px', sm: '640px', md: '768px', lg: '1024px' });
const columns = mapCurrent({ lg: 2 }, 1);

const date = ref(new Date());
const selectAttribute = ref({ dot: true });
const plan = ref({});
const schedule = ref();
const isDark = ref(true);
const apiStore = useApiStore();

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

onMounted(() => {
    apiStore.fetchDefaultPlan();
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
