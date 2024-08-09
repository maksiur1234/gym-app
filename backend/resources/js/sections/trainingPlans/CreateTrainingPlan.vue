<template>
    <h1 class="p-4">Stwórz plan treningowy</h1>
    <form @submit.prevent="submitForm">
        <div class="card flex p-4">
            <FloatLabel>
                <InputText id="name" v-model="formData.name" required />
                <label for="name">Nazwa Planu</label>
            </FloatLabel>
        </div>

        <div class="card flex p-4">
            <FloatLabel>
                <Textarea id="desc" rows="5" cols="30" v-model="formData.desc" />
                <label for="desc">Opis planu: cele treningowe, itp</label>
            </FloatLabel>
        </div>

        <div class="card flex p-4">
            <Select v-model="formData.trainer_id" :options="users" optionLabel="name" placeholder="Wybierz Użytkownika" class="w-full md:w-56">
                <template #value="slotProps">
                    <div v-if="slotProps.value" class="flex items-center">
                        <div>{{ slotProps.value.name }}</div>
                    </div>
                    <span v-else>
                        {{ slotProps.placeholder }}
                    </span>
                </template>
                <template #option="slotProps">
                    <div class="flex items-center">
                        <div>{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Select>
        </div>

        <div class="card flex p-4">
            <Button label="Dodaj jednostkę treningową" @click="addTrainingDay" />
        </div>

        <div v-for="(day, dayIndex) in formData.training_days" :key="dayIndex">
            <h3>Dzień treningowy {{ dayIndex + 1 }}</h3>
            <div class="card flex p-4" v-for="(exercise, exIndex) in day.exercises" :key="exIndex">
                <Select v-model="exercise.id" required>
                    <option v-for="ex in exercises" :key="ex.id" :value="ex.id">
                        {{ ex.name }}
                    </option>
                </Select>
                <FloatLabel>
                    <InputNumber v-model="exercise.sets" placeholder="Serii" required />
                    <label for="sets">Ilość serii</label>
                </FloatLabel>
                <FloatLabel>
                    <InputNumber v-model="exercise.reps" placeholder="Powtórzeń" required />
                    <label for="reps">Ilość powtórzeń</label>
                </FloatLabel>
                <FloatLabel>
                    <InputNumber v-model="exercise.weight" placeholder="Ciężar (kg)" />
                    <label for="weight">Ciężar</label>
                </FloatLabel>
                <FloatLabel>
                    <InputNumber v-model="exercise.rest_time" placeholder="Czas odpoczynku (s)" />
                    <label for="rest_time">Długość przerwy (min)</label>
                </FloatLabel>
                <Button label="Usuń wiersz" @click="removeExercise(dayIndex, exIndex)" />
            </div>
            <div class="p-2">
                <Button label="Dodaj wiersz" @click="addExercise(dayIndex)" />
            </div>
            <div class="p-2">
                <Button label="Usuń jednostkę treningową" @click="removeTrainingDay(dayIndex)" />
            </div>
        </div>

        <div class="card flex p-4">
            <Button label="Zapisz Plan" type="submit" />
        </div>
    </form>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

const formData = reactive({
    name: '',
    desc: '',
    trainer_id: null,
    training_days: [],
    created_by: 1,
    user_id: 1,
});

const users = ref([]);
const exercises = ref([]);

const fetchUsers = async () => {
    try {
        const response = await axios.get('/all-users');
        users.value = response.data.data.map(user => ({
            id: user.id,
            name: `${user.name} ${user.surname}`
        }));
    } catch (error) {
        console.error('Error fetching users:', error);
    }
};

const fetchExercises = async () => {
    try {
        const response = await axios.get('/all-exercises'); // Upewnij się, że endpoint jest poprawny
        exercises.value = response.data;
    } catch (error) {
        console.error('Error fetching exercises:', error);
    }
};

const addTrainingDay = () => {
    formData.training_days.push({ exercises: [] });
};

const removeTrainingDay = (index) => {
    formData.training_days.splice(index, 1);
};

const addExercise = (dayIndex) => {
    formData.training_days[dayIndex].exercises.push({
        id: '',
        sets: '',
        reps: '',
        weight: '',
        rest_time: ''
    });
};

const removeExercise = (dayIndex, exerciseIndex) => {
    formData.training_days[dayIndex].exercises.splice(exerciseIndex, 1);
};

const submitForm = async () => {
    try {
        await axios.post('/store-training-plans', formData, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        });
        alert('Plan treningowy został zapisany');
    } catch (error) {
        console.error('Error saving training plan:', error);
    }
};

onMounted(() => {
    fetchUsers();
    fetchExercises();
});
</script>

<style scoped>
</style>
