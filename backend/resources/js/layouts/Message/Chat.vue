<template>
    <div class="chat-container">
      <h2>Chat z użytkownikiem</h2>
  
      <div class="chat-messages">
        <div v-for="message in messages" :key="message.id" :class="message.sender_id === userId ? 'message-sent' : 'message-received'">
          <p>{{ message.message }}</p>
          <small>{{ formatDate(message.created_at) }}</small>
        </div>
      </div>
  
      <form @submit.prevent="sendMessage">
        <input type="hidden" v-model="receiverId">
        <textarea v-model="newMessage" placeholder="Wpisz wiadomość..." required></textarea>
        <button type="submit" :disabled="loading || newMessage.trim() === ''">Wyślij</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const userId = ref(7); // Identyfikator użytkownika - powinno być dynamiczne
  const receiverId = ref(7); // Identyfikator odbiorcy - powinno być dynamiczne
  const messages = ref([]);
  const newMessage = ref('');
  const loading = ref(false);
  const error = ref(null);
  
  // Funkcja do pobierania wiadomości
  const fetchMessages = async () => {
    try {
      const response = await axios.get(`/chat/${receiverId.value}`);
      messages.value = response.data.data;
    } catch (err) {
      error.value = 'Nie udało się pobrać wiadomości.';
      console.error(err);
    }
  };
  
  // Funkcja do wysyłania wiadomości
  const sendMessage = async () => {
    loading.value = true;
    try {
      const response = await axios.post(`/chat/store`, {
        message: newMessage.value,
        sender_id: userId.value,
        receiver_id: receiverId.value,
      });
      
      // Po wysłaniu wiadomości dodaj ją do listy
      messages.value.push(response.data);
      newMessage.value = ''; // Wyczyść pole tekstowe
    } catch (err) {
      error.value = 'Nie udało się wysłać wiadomości.';
      console.error(err);
    } finally {
      loading.value = false;
    }
  };
  
  // Pobieranie wiadomości przy załadowaniu komponentu
  onMounted(() => {
    fetchMessages();
  });
  
  // Formatowanie daty
  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleString();
  };
  </script>
  
  <style scoped>
  .chat-container {
    padding: 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    max-width: 600px;
    margin: auto;
  }
  
  .chat-messages {
    margin-bottom: 16px;
    max-height: 400px;
    overflow-y: auto;
  }
  
  .message-sent {
    text-align: right;
    background-color: #d4edda;
    padding: 8px;
    border-radius: 8px;
    margin: 5px 0;
  }
  
  .message-received {
    text-align: left;
    background-color: #f8d7da;
    padding: 8px;
    border-radius: 8px;
    margin: 5px 0;
  }
  
  textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 8px;
  }
  
  button {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button:disabled {
    background-color: #6c757d;
  }
  </style>
  