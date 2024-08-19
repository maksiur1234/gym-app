<template>
    <div class="space-y-6">
        <div v-for="index in trainingDays" :key="index" class="border p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4">Jednostka treningowa {{ index }}</h3>
            <table class="w-full border-collapse">
                <thead>
                <tr class="border-b">
                    <th class="p-2 text-left">Nazwa ćwiczenia</th>
                    <th class="p-2 text-left">Ilość serii</th>
                    <th class="p-2 text-left">Ilość powtórzeń</th>
                    <th class="p-2 text-left">RIR</th>
                    <th class="p-2 text-left">Tempo</th>
                    <th class="p-2 text-left">Przerwa</th>
                    <th class="p-2 text-left">Akcja</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(row, rowIndex) in rows[index]" :key="rowIndex" class="border-b">
                    <td class="p-2"><InputText v-model="row.name" class="w-full" /></td>
                    <td class="p-2"><InputText v-model="row.sets" class="w-full" /></td>
                    <td class="p-2"><InputText v-model="row.reps" class="w-full" /></td>
                    <td class="p-2"><InputText v-model="row.rir" class="w-full" /></td>
                    <td class="p-2"><InputText v-model="row.tempo" class="w-full" /></td>
                    <td class="p-2"><InputText v-model="row.break" class="w-full" /></td>
                    <td class="p-2">
                        <Button label="Usuń wiersz" @click="removeRow(index, rowIndex)" class="bg-red-500 text-white hover:bg-red-600" />
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="mt-4 flex justify-end space-x-2">
                <Button label="Dodaj wiersz" @click="addRow(index)" class="bg-blue-500 text-white hover:bg-blue-600" />
            </div>
        </div>
        <div class="card flex justify-center p-2">
            <!-- Opcjonalnie, dodatkowa zawartość -->
        </div>
    </div>
</template>

<script setup>
import {ref, inject, onMounted} from 'vue';
import axios from 'axios';

const trainingDays = inject('trainingDays');
const rows = inject('rows');

const addRow = (dayIndex) => {
    if (!rows.value[dayIndex]) {
        rows.value[dayIndex] = [];
    }
    rows.value[dayIndex].push({
        name: '',
        sets: '',
        reps: '',
        rir: '',
        tempo: '',
        break: ''
    });
};

const removeRow = (dayIndex, rowIndex) => {
    if (rows.value[dayIndex]) {
        rows.value[dayIndex].splice(rowIndex, 1);
    }
};

</script>

<style scoped>
.table-container {
    margin-bottom: 20px;
}
</style>
