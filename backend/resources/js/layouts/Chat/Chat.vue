<template>
    <div class="chat-container">
      <div class="messages" v-for="msg in messages" :key="msg.id">
        <strong>{{ msg.user_id === userId ? 'Ty' : trainerName }}</strong>: {{ msg.text }}
      </div>
      <form @submit.prevent="sendMessage">
        <input v-model="newMessage" type="text" placeholder="Napisz wiadomość..." class="form-control" />
        <button type="submit">Wyślij</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const props = defineProps(['trainerId']);
  const userId = ref(null);
  const messages = ref([]);
  const newMessage = ref('');
  const trainerName = ref('');
  
  const fetchMessages = async () => {
    const response = await axios.get(`/messages/${props.trainerId}`);
    messages.value = response.data;
  };
  
  const sendMessage = async () => {
    if (!newMessage.value.trim()) return;
  
    const message = {
      user_id: userId.value,
      text: newMessage.value,
      time: new Date().toLocaleTimeString(),
    };
  
    await axios.post('/message', message);
    newMessage.value = ''; 
    fetchMessages();
  };
  
  const fetchUserData = async () => {
    const response = await axios.get('/fetch-user-data');
    userId.value = response.data.user.id;
  };
  
  const fetchTrainerData = async () => {
    const response = await axios.get(`/trainers/${props.trainerId}`);
    trainerName.value = response.data.name; 
  };
  
  onMounted(() => {
    fetchUserData();
    fetchMessages();
    fetchTrainerData();
  });
  </script>
  
  <style scoped>
  .chat-container {
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    height: 100vh;
  }
  .messages {
    height: 80%;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 10px;
    background-color: #f7f7f7;
    display: flex;
    flex-direction: column;
  }
  .form-control {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  </style>
  