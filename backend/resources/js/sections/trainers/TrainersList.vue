<template>
  <div class="flex flex-wrap gap-4 p-2 m-2">
    <Card v-for="trainer in trainers" :key="trainer.id" style="width: 25rem; overflow: hidden">
      <template #header>
        <div class="flex justify-center mt-4">
          <img alt="trainer avatar" :src="trainer.profile_photo_path" class="max-w-full max-h-40 w-auto h-auto rounded-full object-cover"/>
        </div>
      </template>
      <template #title>{{ trainer.name }} {{ trainer.surname }}</template>
      <template #subtitle>Staż treningowy: {{ trainer.training_intership }} lata</template>
      <template #content>
        <p class="m-0">
          {{ truncateText(trainer.desc, 150) }}
        </p>
      </template>
      <template #footer>
        <div class="flex gap-4 mt-1">
          <Button as="a" label="Zobacz profil" :href="`/trainers/profile/${trainer.id}`" rel="noopener" class="mr-2" severity="secondary" />
          <Button @click="() => handleCollaboration(trainer.id)" label="Napisz wiadomość" class="mr-2"/>
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const trainers = ref([]);
const user = ref({});
const userId = ref();

const fetchUserData = async () => {
  try {
    const response = await axios.get('/fetch-user-data');
    user.value = response.data;
    userId.value = user.value.user.id;
  } catch (error) {
    console.error(error);
  }
};

const fetchTrainers = async () => {
  try {
    const response = await axios.get('/all-trainers');
    trainers.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
}

const truncateText = (text, maxLength) => {
  return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}

const handleCollaboration = async (trainerId) => {
  if (!userId.value) {
    alert('Nie udało się pobrać danych użytkownika.');
    return;
  }

  try {
    
    // Przekierowanie do czatu
    window.location.href = `/chat/${trainerId}`;
  } catch (error) {
    console.error('Błąd wysyłania powiadomienia:', error);
    alert('Nie udało się wysłać powiadomienia.');
  }
}


onMounted(() => {
  fetchUserData();
  fetchTrainers();
});
</script>
