
<template>
    <div class="card">
        <Toast />
        <Panel toggleable header="Podstawowe statystyki" v-if="apiStore.user">
            <template #icons>
                <Button icon="pi pi-cog" severity="secondary" rounded text @click="toggle" />
                <Menu ref="menu" id="config_menu" :model="items" popup />
            </template>
            <p class="m-0">

                <p>Wiek: {{ apiStore.user.age }}</p>
                <p>Waga: {{ apiStore.user.weight }}</p>
                <p>Wzrost: {{ apiStore.user.height }}</p>
                <p>Staż treningowy: {{ apiStore.user.training_intership }} lat</p>
            </p>
            
        </Panel>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useApiStore } from '../../stores/apiStore';

const apiStore = useApiStore();

onMounted(() => {
    apiStore.fetchUserData();
})

</script>
<style scoped>
</style>
