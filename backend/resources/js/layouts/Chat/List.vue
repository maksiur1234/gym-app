<template>
  <div class="flex justify-center items-center min-h-screen w-full">
    <Card class="max-w-md w-full shadow-lg rounded-lg border border-gray-200">
      <template #title>
        <Button
          as="a"
          label="Wróć"
          href="/dashboard"
          rel="noopener"
          class="rounded-lg bg-gradient-to-br from-blue-500 to-indigo-700 text-white font-bold py-2 px-4 hover:ring-2 cursor-pointer ring-offset-2 ring-blue-300 transition-all"
        />
        <h2 class="text-lg font-semibold text-center py-4">Twoje czaty</h2>
      </template>
      <template #content>
        <div class="flex flex-col mb-2 p-4">
          <a href="/global-chat" class="mb-2 text-blue-500 hover:underline">Czat Globalny</a>
          <div v-for="chat in activeChats" :key="chat.id">
            <a :href="`/chat/${chat.id}`" 
               class="block mb-2 text-blue-600 hover:text-blue-800 hover:underline transition">
              Czat z uzytkownikiem: {{ chat.name }}
            </a>
          </div>
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const currentUserId = ref(localStorage.getItem('userId'));
const activeChats = ref([]);

const fetchActiveChats = async () => {
    const response = await fetch('/chats');
    activeChats.value = await response.json();
};

onMounted(() => {
    fetchActiveChats();
});
</script>
