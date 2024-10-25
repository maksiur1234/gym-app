<template>
    <div class="max-w-lg mx-auto p-4 bg-slate-400 shadow-md rounded-lg">
        <div class="border-b pb-2 mb-4">
            <h2 class="text-2xl font-bold text-black-800">{{ planName }}</h2>
            <p class="text-black-600">{{ planDesc }}</p>
        </div>

        <div v-if="currentDayExercises.length > 0" class="space-y-4">
            <h3 class="text-xl font-semibold text-black-600">Aktualne ćwiczenie: {{ getCurrentExercise().exercise_name }}</h3>
            <p class="text-black-700">Ilość serii: <span class="font-medium">{{ getCurrentExercise().sets }}</span></p>
            <p class="text-black-700">Ilość powtórzeń: <span class="font-medium">{{ getCurrentExercise().reps }}</span></p>
        </div>

        <div v-else class="text-center py-4">
            <p class="text-black-500">Brak ćwiczeń do wyświetlenia.</p>
        </div>

        <div class="mt-6">
            <Button 
                v-if="currentExerciseIndex < currentDayExercises.length - 1 && !isTrainingEnded" 
                label="Następne ćwiczenie" 
                @click="goToNextExercise" 
            />
            <Button 
                v-else 
                :disabled="isTrainingEnded" 
                label="Zakończ ćwiczenie" 
                @click="finishLastExercise" 
            />
        </div>

        <div v-if="showingSummary" class="mt-8 bg-black-200 p-4 rounded-lg">
            <h3 class="text-lg font-semibold">Podsumowanie sesji:</h3>
            <ul>
                <li v-for="(stat, index) in exerciseStats" :key="index" class="mt-2">
                    <strong>{{ stat.name }}:</strong> 
                    Serii: {{ stat.sets }}, Powtórzeń na serię: {{ stat.reps }}
                </li>
            </ul>
            <p class="mt-4">Łączna ilość serii: {{ totalSets }}</p>
            <p>Łączna ilość powtórzeń: {{ totalReps }}</p>
            <Button label="Zakończ trening" severity="danger" @click="endTraining" />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
const props = defineProps(['sessionId']);
console.log(props.sessionId)

const currentPlanId = ref(null);
const planName = ref('');
const planDesc = ref('');
const currentDayExercises = ref([]); 
const currentExerciseIndex = ref(0);
const showingSummary = ref(false);
const isTrainingEnded = ref(false); 

const exerciseStats = ref([]);
const totalSets = ref(0);
const totalReps = ref(0);

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
    if (currentExerciseIndex.value < currentDayExercises.value.length) {
        const exercise = getCurrentExercise();
        exerciseStats.value.push({
            name: exercise.exercise_name,
            sets: exercise.sets,
            reps: exercise.reps
        });
        totalSets.value += exercise.sets;
        totalReps.value += exercise.sets * exercise.reps;
        currentExerciseIndex.value++;
    }
};

const finishLastExercise = () => {
    const exercise = getCurrentExercise();
    exerciseStats.value.push({
        name: exercise.exercise_name,
        sets: exercise.sets,
        reps: exercise.reps
    });
    totalSets.value += exercise.sets;
    totalReps.value += exercise.sets * exercise.reps;
    showingSummary.value = true; 
    isTrainingEnded.value = true; 
};

const endTraining = async () => {
    try {
        await axios.post('/workout/end', {
            session_id: props.sessionId,
            total_sets: totalSets.value,
            total_reps: totalReps.value,
            exercises: exerciseStats.value
        });
        alert('Trening zakończony.');
        window.location.href = '/dashboard';
    } catch (error) {
        console.error("Błąd podczas kończenia treningu:", error);
    }
};

onMounted(() => {
    fetchCurrentPlan();
});
</script>
