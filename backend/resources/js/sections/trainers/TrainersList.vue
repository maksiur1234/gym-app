<template>
    <div class="flex flex-wrap gap-4 p-2 m-2">
        <Card v-for="trainer in trainers" style="width: 25rem; overflow: hidden">
            <template #header>
                <div class="flex justify-center mt-4">
                    <img alt="trainer avatar" :src="trainer.profile_photo_path" class="max-w-full max-h-40 w-auto h-auto rounded-full object-cover"/>
                </div>
            </template>
            <template #title>{{ trainer.name }} {{ trainer.surname }}</template>
            <template #subtitle>Staż treningowy: {{ trainer.training_intership }} lata</template>
            <template #content>
                <p class="m-0">
                    {{ trainer.desc }}
                </p>
            </template>
            <template #footer>
                <div class="flex gap-4 mt-1">
                    <Button label="Zobacz profil" severity="secondary" outlined class="w-full" />
                    <Button label="Wyślij prośbę o współpracę" class="w-full" />
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const trainers = ref([]);

const fetchTrainers = async () => {
    try {
        const response = await axios.get('/all-trainers');
        trainers.value = response.data.data;
    } catch (error) {
        console.error(error);
    }
}


onMounted(() => {
    fetchTrainers();
});
</script>
