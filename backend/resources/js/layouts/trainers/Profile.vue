<template>
    <Card class="w-3/4 max-w-4xl mx-auto p-6 shadow-lg rounded-lg bg-white dark:bg-gray-800">
    <template #title>
            <Button
                as="a"
                label="Wróć do listy"
                href="/dashboard"
                rel="noopener"
                class="rounded-lg bg-gradient-to-br from-blue-500 to-indigo-700 text-white font-bold py-2 px-4 hover:ring-2 cursor-pointer ring-offset-2 ring-blue-300 transition-all"
            />
        </template>
        <template #content>
            <div v-if="trainer" class="flex flex-col items-center text-center">
                <img
                    :src="trainer.profile_photo_path"
                    alt="Trainer avatar"
                    class="rounded-full w-20 h-20 object-cover shadow-md mb-4"
                />
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ trainer.name }} {{ trainer.surname }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">
                    {{ trainer.desc }}
                </p>
                <div class="mt-4 grid grid-cols-2 gap-4 w-full">
                    <div>
                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wiek</span>
                        <span class="block text-xl font-bold text-gray-900 dark:text-gray-100">{{ trainer.age }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wzrost</span>
                        <span class="block text-xl font-bold text-gray-900 dark:text-gray-100">{{ trainer.height }} cm</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waga</span>
                        <span class="block text-xl font-bold text-gray-900 dark:text-gray-100">{{ trainer.weight }} kg</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Staż treningowy</span>
                        <span class="block text-xl font-bold text-gray-900 dark:text-gray-100">{{ trainer.training_intership }} lata</span>
                    </div>
                </div>
            </div>
            <p v-else class="text-center text-gray-500 dark:text-gray-400">Loading...</p>
        </template>
        <template #footer>
            <div class="mt-6 flex justify-end">
                <Button
                    label="Wyślij prośbę o współpracę"
                    class="rounded-lg bg-green-500 text-white font-bold py-2 px-4 hover:bg-green-600 transition-all"
                />
            </div>
        </template>
    </Card>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    trainerId: Number
});

const trainer = ref(null);

const fetchTrainer = async () => {
    try {
        const response = await axios.get(`/trainers/info/${props.trainerId}`);
        trainer.value = response.data;
    } catch (error) {
        console.error('Error fetching trainer data:', error);
    }
}

onMounted(() => {
    fetchTrainer();
});
</script>
