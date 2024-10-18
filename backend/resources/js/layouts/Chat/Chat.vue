<template>
  <div class="flex justify-center items-center min-h-screen w-full">
    <Card>
      <template #title>
        <Button
          as="a"
          label="Wróć"
          href="/all-chats"
          rel="noopener"
          class="rounded-lg bg-gradient-to-br from-blue-500 to-indigo-700 text-white font-bold py-2 px-4 hover:ring-2 cursor-pointer ring-offset-2 ring-blue-300 transition-all"
        />
      </template>
      <template #content>
        <div class="chat-container">
          <div class="messages">
            <div 
              v-for="(msg, index) in messages" 
              :key="index" 
              :class="{'message-sent': msg.user_id === userId, 'message-received': msg.user_id !== userId}"
              class="message-item"
            >
              <strong>{{ msg.user_id }}</strong>: {{ msg.text }}
              <div v-if="msg.status === 'pending' && msg.receiver_id === userId">
                <Button class="m-2" label="Akceptuj" @click="acceptRequest(msg.id)" />
                <Button label="Odrzuć" @click="rejectRequest(msg.id)" severity="danger"/>
              </div>
            </div>
          </div>
          <div class="message-info p-4" v-if="messages.every(msg => msg.status === 'pending')">
            <p>Aby napisać wiadomość, prośba musi zostać zaakceptowana.</p>
          </div>
          <div class="message-info p-4" v-if="messages.every(msg => msg.status === 'rejected')">
            <p>Prośba została odrzucona.</p>
          </div>
          <div v-else-if="messages.some(msg => msg.status === 'accepted')">
            <form class="form-container p-2" @submit.prevent="sendMessage">
              <InputText v-model="newMessage" type="text" size="large" placeholder="Napisz wiadomość" />
              <Button label="Wyślij wiadomość" type="submit" />
            </form>
          </div>
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import '../../echo'; 
import axios from 'axios';

const newMessage = ref('');
const messages = ref([]);
const userId = ref(null); 
const receiverId = ref(null); 

const fetchPrivateMessages = async (receiverId) => {
  const response = await fetch(`/chat/private/${receiverId}`); 
  messages.value = await response.json();
};

const listenForMessages = () => {
  if (userId.value) {
    window.Echo.private('private-channel.' + userId.value)
      .listen('GotMessage', (event) => {
        messages.value.push(event.message);
      });
  }
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
    receiver_id: receiverId.value, 
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

const acceptRequest = async (messageId) => {
  const csrfToken = await getCsrfToken(); 

  await fetch(`/accept-message/${messageId}`, {
     method: 'POST',
     headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken, 
      },
    });
};

const rejectRequest = async (messageId) => {
  const csrfToken = await getCsrfToken(); 

  await fetch(`/reject-message/${messageId}`, { 
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken, 
      },
  });
};

onMounted(() => {
  const userData = document.querySelector('.flex-grow').getAttribute('data-user');
  userId.value = JSON.parse(userData).id; 

  const urlParts = window.location.pathname.split('/');
  receiverId.value = urlParts[urlParts.length - 1];

  fetchPrivateMessages(receiverId.value);
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
  background-color: #f7f7f7;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.messages {
  flex-grow: 1;
  overflow-y: auto;
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 10px;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  gap: 10px; 
}

.message-item {
  max-width: 70%;
  padding: 10px;
  border-radius: 10px;
  margin-bottom: 10px;
  word-wrap: break-word;
  position: relative;
}

.message-sent {
  align-self: flex-start;
  background-color: #d1e7dd; 
  color: #0f5132;
}

.message-received {
  align-self: flex-end;
  background-color: #f8d7da; 
  color: #721c24; 
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
  transition: background-color 0.3s;
}

.btn:hover {
  background-color: #0056b3;
}

.message-info {
  color:red;
}
</style>
