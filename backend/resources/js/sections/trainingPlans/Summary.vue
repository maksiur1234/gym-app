<template>
    <div class="p-6 max-w-6xl mx-auto shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold mb-6">Podsumowanie</h2>

        <!-- User Information -->
        <div v-if="selectedUser" class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Szczegóły użytkownika</h2>
            <div class="flex items-center mb-6">
                <img :src="selectedUser.profile_photo_path" alt="Profile Photo" class="w-20 h-20 rounded-full shadow-lg mr-6"/>
                <div>
                    <h3 class="text-xl font-bold">{{ selectedUser.name }} {{ selectedUser.surname }}</h3>
                    <p class="text-gray-700">{{ selectedUser.email }}</p>
                    <p class="text-gray-500">{{ selectedUser.desc }}</p>
                </div>
            </div>
        </div>

        <!-- Training Plan Information -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Plan treningowy:</h3>
            <div class="p-4 rounded-lg border border-gray-300">
                <p><strong>Nazwa:</strong> {{ name }}</p>
                <p><strong>Opis:</strong> {{ desc }}</p>
            </div>
        </div>

        <!-- Training Units Summary -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Podsumowanie Jednostek Treningowych</h3>
            <div v-for="(dayRows, dayIndex) in rows" :key="dayIndex" class="mb-6">
                <h4 class="text-lg font-semibold mb-2">Jednostka treningowa {{ dayIndex + 1 }}</h4>
                <table class="w-full border-collapse rounded-lg overflow-hidden">
                    <thead>
                    <tr class="border-b">
                        <th class="p-3 text-left">Nazwa ćwiczenia</th>
                        <th class="p-3 text-left">Ilość serii</th>
                        <th class="p-3 text-left">Ilość powtórzeń</th>
                        <th class="p-3 text-left">RIR</th>
                        <th class="p-3 text-left">Tempo</th>
                        <th class="p-3 text-left">Przerwa</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, rowIndex) in dayRows" :key="rowIndex" class="border-b">
                        <td class="p-3">{{ row.name }}</td>
                        <td class="p-3">{{ row.sets }}</td>
                        <td class="p-3">{{ row.reps }}</td>
                        <td class="p-3">{{ row.rir }}</td>
                        <td class="p-3">{{ row.tempo }}</td>
                        <td class="p-3">{{ row.break }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Additional Information -->
        <div v-if="additionalInfo" class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Dodatkowe informacje:</h3>
            <div class="p-4 rounded-lg border">
                <pre>{{ additionalInfo }}</pre>
            </div>
        </div>
    </div>
</template>

<script setup>
import { inject } from 'vue';

const selectedUser = inject('selectedUser');
const name = inject('name');
const desc = inject('desc');
const rows = inject('rows');
const additionalInfo = inject('additionalInfo');
</script>

<style scoped>
</style>
