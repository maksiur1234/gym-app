
<template>
    <div class="card" v-for="user in loggedUser">
        <Toast />
        <Panel toggleable header="Podstawowe statystyki">
            <template #icons>
                <Button icon="pi pi-cog" severity="secondary" rounded text @click="toggle" />
                <Menu ref="menu" id="config_menu" :model="items" popup />
            </template>
            <p class="m-0">

                <p>Wiek: {{ user.age }}</p>
                <p>Waga: {{ user.weight }}</p>
                <p>Wzrost: {{ user.height }}</p>
                <p>Staż treningowy: {{ user.training_intership }} lat</p>
            </p>
        </Panel>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const loggedUser = ref([]);

const fetchUser = async () => {
    try {
        const response = await axios.get('/fetch-user-data');
        loggedUser.value = response.data;
    } catch (error) {
        console.error(error);
    }

};

onMounted(() => {
    fetchUser();
})

</script>
<style scoped>
</style>
