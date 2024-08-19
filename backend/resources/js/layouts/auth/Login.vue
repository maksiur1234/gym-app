<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-900">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-semibold mb-6 text-green-500">Logowanie</h2>
            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 mb-2">Email</label>
                    <input v-model="email" type="email" id="email" placeholder="Wprowadź email" class="w-full p-2 rounded border border-gray-700 bg-gray-900 text-gray-300" required />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-300 mb-2">Hasło</label>
                    <input v-model="password" type="password" id="password" placeholder="Wprowadź hasło" class="w-full p-2 rounded border border-gray-700 bg-gray-900 text-gray-300" required />
                </div>
                <button type="submit" class="w-full py-2 bg-green-500 text-white rounded hover:bg-green-600">Zaloguj się</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const email = ref('');
const password = ref('');

const handleSubmit = async () => {
    try {
        const response = await axios.post('/login', {
            email: email.value,
            password: password.value,
        });
        console.log('Zalogowano:', response.data);
    } catch (error) {
        console.error('Błąd logowania:', error);
    }
};
</script>

<style scoped>
/* Custom styles */
</style>
