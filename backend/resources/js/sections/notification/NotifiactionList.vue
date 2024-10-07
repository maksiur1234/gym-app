<template>
  <h2>Twoje Powiadomienia</h2>
  <div class="notifications-container">
    <div v-if="loading">Ładowanie powiadomień...</div>
    <div v-if="error" class="error">{{ error }}</div>
    <ul v-if="!loading && !error">
      <li v-for="notification in notifications" :key="notification.id" class="notification-item">
        <p><strong>Data:</strong> {{ formatDate(notification.created_at) }}</p>
        <p><strong>Wiadomość:</strong> {{ notification.message }}</p>
        <p><a :href="`/chat/${notification.trainer_id}`">Zobacz cały chat</a></p>
      </li>
    </ul>
    <div v-if="notifications.length === 0">Brak powiadomień.</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const notifications = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchNotifications = async () => {
  try {
    const response = await axios.get('/all-notifications');
    notifications.value = response.data.data;
  } catch (err) {
    error.value = 'Nie udało się pobrać powiadomień.';
    console.error(err);
  } finally {
    loading.value = false;
  }
}

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleString();
}

onMounted(() => {
  fetchNotifications();
});
</script>

<style scoped>
.notifications-container {
  padding: 16px;
  border: 1px solid #ddd;
  border-radius: 8px;
  max-width: 600px;
  margin: auto;
}

.notification-item {
  padding: 10px;
  border-bottom: 1px solid #eee;
}

.error {
  color: red;
}
</style>
