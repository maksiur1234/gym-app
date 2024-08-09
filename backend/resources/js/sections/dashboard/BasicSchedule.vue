
<template>
    <div class="card" v-for="user in loggedUser">
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
                <vue-cal
                    :style="calendarStyle"
                    :events="events"
                    :time="time"
                ></vue-cal>
        </Panel>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'

const loggedUser = ref([]);

const calendarStyle = {
    height: '400px',
    backgroundColor: '#3b403c',
    color: '#ffffff',
    padding: '20px'
};

const events = ref([
    {
        start: '2024-07-29 0:00',
        end: '2024-07-29 1:30',
        title: 'Trening siłowy: Trening 1'
    },
    {
        start: '2024-07-30 11:30',
        end: '2024-07-30 13:30',
        title: 'Trening siłowy: Trening 2'
    }
])

const fetchUser = async () => {
    try {
        const response = await axios.get('/fetch-user-data');
        loggedUser.value = response.data
        console.log(loggedUser.value);
    } catch (error) {
        console.error(error);
    }

};

onMounted(() => {
    fetchUser();
})

</script>
<style scoped>
.p-panel {
    background-color: rgb(34, 146, 79);
}
</style>
