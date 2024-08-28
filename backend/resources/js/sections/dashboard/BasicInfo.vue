
<template>
    <div class="card" v-for="user in loggedUser">
        <Toast />
        <Panel toggleable>
            <template #header>
                <div class="flex items-center gap-2">
                    <img :src="user.profile_photo_path" alt="Profile Photo" class="w-16 h-16 rounded-full">
                    <span class="font-bold">{{ user.name }} {{ user.surname }} </span>
                </div>
            </template>
            <template #footer>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <Button icon="pi pi-user" rounded text></Button>
                        <Button icon="pi pi-bookmark" severity="secondary" rounded text></Button>
                    </div>
                    <span class="text-surface-500 dark:text-surface-400">Staż treningowy: {{ user.training_intership }} lat</span>
                </div>
            </template>
            <template #icons>
                <Button icon="pi pi-cog" severity="secondary" rounded text @click="toggle" />
                <Menu ref="menu" id="config_menu" :model="items" popup />
            </template>
            <p class="m-0">
                <h1>Aktualny plan treningowy: </h1>
                <div v-if="plan">
                    <h2>{{plan.name}}</h2>
                    <p>{{plan.desc}}</p>
                </div>
            </p>
        </Panel>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const loggedUser = ref([]);
const plan = ref();

const fetchDefaultPlan = async () => {
    try {
        const response = await axios.get('/user/get-default-plan');
        plan.value = response.data;
        console.log(plan.value)
    } catch (error) {
        console.error('Error fetching default plan:', error);
    }
};
const fetchUser = async () => {
  try {
    const response = await axios.get('/fetch-user-data');
    loggedUser.value = response.data
  } catch (error) {
    console.error(error);
  }

};

onMounted(() => {
  fetchUser();
  fetchDefaultPlan();
})

</script>
<style scoped>
.p-panel {
  background-color: rgb(34, 146, 79);
}
</style>
