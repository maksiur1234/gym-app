<template>
  <div class="flex flex-wrap gap-4 p-2 m-2">
    <Card v-for="trainer in trainers" :key="trainer.id" style="width: 25rem; overflow: hidden">
      <template #header>
        <div class="flex justify-center mt-4">
          <img alt="trainer avatar" :src="trainer.profile_photo_path" class="max-w-full max-h-40 w-auto h-auto rounded-full object-cover"/>
        </div>
      </template>
      <template #title>{{ trainer.name }} {{ trainer.surname }}</template>
      <template #subtitle>Staż treningowy: {{ trainer.training_intership }} lat</template>
      <template #content>
        <p class="m-0">
          {{ truncateText(trainer.desc, 150) }}
        </p>
      </template>
      <template #footer>
        <div class="flex gap-4 mt-1">
          <Button as="a" label="Zobacz profil" :href="`/trainers/profile/${trainer.id}`" rel="noopener" class="mr-2" severity="secondary" />
          <Button 
            @click="() => handleCollaboration(trainer.id)" 
            label="Napisz wiadomość" 
            class="mr-2" 
            :disabled="trainer.id === userId" 
          />
        </div>
      </template>
    </Card>
  </div>
  <div class="flex justify-between items-center mt-4">
            <button
                @click="previousPage"
                :disabled="currentPage === 1"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50"
            >
                Poprzednia
            </button>
            <span>Strona {{ currentPage }} z {{ totalPages }}</span>
            <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50"
            >
                Następna
            </button>
        </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useApiStore } from '../../stores/apiStore';

const trainers = ref([]);
const apiStore = useApiStore();
const userId = ref(null);
const currentPage = ref(1);
const totalPages = ref();

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
  try {
    window.location.href = `/chat/${trainerId}`;
  } catch (error) {
    console.error('Błąd wysyłania powiadomienia:', error);
    alert('Nie udało się wysłać powiadomienia.');
  }
}

const nextPage = () => {
    if(currentPage.value < totalPages.value){
        currentPage.value++;
        fetchUsers();
    }
}

const previousPage = () => {
    if(currentPage.value > 1){
        currentPage.value--;
        fetchUsers();
    }
}

onMounted(async () => {
  apiStore.fetchUserData();
  userId.value = apiStore.user.id; 
  fetchTrainers();
});
</script>
