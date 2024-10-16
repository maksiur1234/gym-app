<template>
    <div class="max-w-lg mx-auto p-4 bg-slate-400 shadow-md rounded-lg">
        <div class="border-b pb-2 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ planName }}</h2>
            <p class="text-gray-600">{{ planDesc }}</p>
        </div>
        
        <div v-if="currentDayExercises.length > 0" class="space-y-4">
            <h3 class="text-xl font-semibold text-primary-600">Aktualne ćwiczenie: {{ getCurrentExercise().exercise_name }}</h3>
            <p class="text-gray-700">Ilość serii: <span class="font-medium">{{ getCurrentExercise().sets }}</span></p>
            <p class="text-gray-700">Ilość powtórzeń: <span class="font-medium">{{ getCurrentExercise().reps }}</span></p>
            <p class="text-gray-700">RIR: <span class="font-medium">{{ getCurrentExercise().rir }}</span></p>
            <p class="text-gray-700">Tempo: <span class="font-medium">{{ getCurrentExercise().tempo }}</span></p>
            <p class="text-gray-700">Przerwa: <span class="font-medium">{{ getCurrentExercise().break }}</span></p>
        </div>
        
        <div v-else class="text-center py-4">
            <p class="text-gray-500">Brak ćwiczeń do wyświetlenia.</p>
        </div>
        
        <div class="mt-6">
            <Button v-if="currentExerciseIndex < currentDayExercises.length - 1" label="Następne ćwiczenie" @click="goToNextExercise" />
            <Button v-else label="Zakończ trening" severity="danger" @click="endTraining" />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const currentPlanId = ref(null);
const planName = ref('');
const planDesc = ref('');
const currentDayExercises = ref([]); 
const currentExerciseIndex = ref(0);

const fetchCurrentPlan = async () => {
    try {
        const response = await axios.get("/user/get-default-plan");
        currentPlanId.value = response.data.id;
        planName.value = response.data.name;
        planDesc.value = response.data.desc;
        await loadExercises();
    } catch (error) {
        console.error("Błąd podczas pobierania bieżącego planu treningowego:", error);
    }
};

const loadExercises = async () => {
    try {
        const response = await axios.get(`/training-plan-details-data/${currentPlanId.value}`);
        const trainingDays = response.data.training_days;

        if (trainingDays && trainingDays.length > 0) {
            const currentDay = trainingDays[0]; 
            currentDayExercises.value = currentDay.exercises;
        }
    } catch (error) {
        console.error("Błąd podczas ładowania ćwiczeń:", error);
    }
};

const getCurrentExercise = () => {
    if (currentDayExercises.value.length > 0 && currentExerciseIndex.value < currentDayExercises.value.length) {
        return currentDayExercises.value[currentExerciseIndex.value];
    } else {
        return {};
    }
};

const goToNextExercise = () => {
    if (currentExerciseIndex.value < currentDayExercises.value.length - 1) {
        currentExerciseIndex.value++;
    }
};

const endTraining = async () => {
    try {
        await axios.post('/workout/end', { session_id: currentSessionId.value });
        console.log('Trening zakończony.');
    } catch (error) {
        console.error("Błąd podczas kończenia treningu:", error);
    }
};

onMounted(() => {
    fetchCurrentPlan();
});
</script>
