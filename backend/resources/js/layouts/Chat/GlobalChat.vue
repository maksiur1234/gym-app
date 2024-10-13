<template>
    <div class="chat-container">
      <div class="messages">
        <div 
          v-for="(msg, index) in messages" 
          :key="index" 
          class="message-item"
        >
          <strong>{{ msg.user_id }}</strong>: {{ msg.text }}
        </div>
      </div>
      <form @submit.prevent="sendMessage" class="form-container">
        <input
          v-model="newMessage"
          type="text"
          placeholder="Napisz wiadomość..."
          class="form-control"
        />
        <button type="submit" class="btn">Wyślij</button>
      </form>
    </div>
  </template>  
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import '../../echo'; 
  import axios from 'axios';
  
  const newMessage = ref('');
  const messages = ref([]);
  const userId = ref(null); 
  
  const fetchMessages = async () => {
    const response = await fetch('/messages'); 
    messages.value = await response.json();
  };
  
  const listenForMessages = () => {
    window.Echo.private('channel-for-everyone')
      .listen('GotMessage', (event) => {

        messages.value.push(event.message);
      });
  };

  const getCsrfToken = async () => {
    await axios.get('/sanctum/csrf-cookie'); 
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    return token;
  };

  const sendMessage = async () => {
    if (!newMessage.value.trim()) return;
  
    const message = {
      user_id: userId.value,
      text: newMessage.value,
      time: new Date().toLocaleTimeString(),
    };
  
    const csrfToken = await getCsrfToken(); 
  
    await fetch('/message', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, 
      },
      body: JSON.stringify(message),
    });
  
    newMessage.value = ''; 
  };
  
  onMounted(() => {
    const userData = document.querySelector('.flex-grow').getAttribute('data-user');
    userId.value = JSON.parse(userData).id; 
    fetchMessages();
    listenForMessages();
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
    margin-bottom: 10px;
    background-color: #f7f7f7;
    display: flex;
    flex-direction: column;
    gap: 10px; 
    color: red;
  }
  
  .message-item {
    max-width: 70%;
    padding: 10px;
    border-radius: 10px;
    background-color: #e0e0e0;
    margin-bottom: 10px;
    word-wrap: break-word;
  }
  
  .form-container {
    display: flex;
    gap: 10px;
  }
  
  .form-control {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  
  .btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
  }
  
  .btn:hover {
    background-color: #0056b3;
  }
  </style>
  