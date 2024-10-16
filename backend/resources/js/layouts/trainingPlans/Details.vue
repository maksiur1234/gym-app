<template>
    <Card style="width: 75%">
        <template #title>
            <div class="mb-2">
                <Button as="a" label="Wróć do listy" href="/training-plans" rel="noopener" class="rounded-lg bg-gradient-to-br from-primary-400 to-primary-700 active:from-primary-700 active:to-primary-900 text-white border-none px-6 py-3 font-bold hover:ring-2 cursor-pointer ring-offset-2 ring-offset-surface-0 dark:ring-offset-surface-900 ring-primary transition-all" />
            </div>
            <hr>
            <h2>Szczegóły planu treningowego</h2>
        </template>
        <template #content>
            <div v-if="plan">
                <div class="py-8">
                    <h3>Nazwa planu: {{ plan.name }}</h3>
                    <p>Opis: {{ plan.desc }}</p>
                    <p>Data utworzenia: {{ new Date(plan.created_at).toLocaleDateString() }}</p>
                    <Button label="Pobierz do PDF" severity="warn" @click="exportToPDF"/>
                </div>
                
                <div v-if="plan.training_days.length">
                    <table class="w-full border-collapse border border-gray-200">
                        <tbody>
                        <tr v-for="day in plan.training_days" :key="day.id">
                            <td class="p-2 border font-bold">{{ day.day_name }}</td>
                            <td colspan="6">
                                <table class="w-full border-collapse border border-gray-300">
                                    <thead>
                                    <tr class="border-b">
                                        <th class="p-2 text-left border">Nazwa ćwiczenia</th>
                                        <th class="p-2 text-left border">Ilość serii</th>
                                        <th class="p-2 text-left border">Ilość powtórzeń</th>
                                        <th class="p-2 text-left border">RIR</th>
                                        <th class="p-2 text-left border">Tempo</th>
                                        <th class="p-2 text-left border">Przerwa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="exercise in day.exercises" :key="exercise.id" class="border-b">
                                        <td class="p-2 border">{{ exercise.exercise_name }}</td>
                                        <td class="p-2 border">{{ exercise.sets }}</td>
                                        <td class="p-2 border">{{ exercise.reps }}</td>
                                        <td class="p-2 border">{{ exercise.rir }}</td>
                                        <td class="p-2 border">{{ exercise.tempo }}</td>
                                        <td class="p-2 border">{{ exercise.break }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <p>Brak dni treningowych w tym planie.</p>
                </div>
            </div>
            <div v-else>Ładowanie szczegółów planu...</div>
        </template>
    </Card>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import jsPDF from 'jspdf';
import 'jspdf-autotable'

const exportToPDF = () => {
    if (!plan.value || !plan.value.training_days) {
        console.error('Brak danych do eksportu');
        return;
    }

    const doc = new jsPDF();
    
    if (plan.value.name) {
        doc.text(`Plan Treningowy: ${plan.value.name}`, 10, 10);
    } else {
        doc.text('Plan Treningowy: brak nazwy', 10, 10);
    }

    plan.value.training_days.forEach(day => {
        if (day.day_name) {
            doc.text(day.day_name, 10, doc.autoTable.previous?.finalY + 10 || 20);
        }

        doc.autoTable({
            head: [['Nazwa cwiczenia', 'Ilosc serii', 'Ilosc powtorzen', 'RIR', 'Tempo', 'Przerwa']],
            body: day.exercises.map(exercise => [
                exercise.exercise_name || '', 
                exercise.sets || '', 
                exercise.reps || '', 
                exercise.rir || '', 
                exercise.tempo || '', 
                exercise.break || ''
            ]),
            startY: doc.autoTable.previous?.finalY + 10 || 30,
        });
    });

    doc.save(`plan_treningowy_${plan.value.name || 'brak_nazwy'}.pdf`);
};


const plan = ref(null);

const planId = new URL(window.location.href).pathname.split('/').pop();

const fetchPlanDetails = async () => {
    try {
        const response = await axios.get(`/training-plan-details-data/${planId}`);
        plan.value = response.data;
    } catch (error) {
        console.error('Error fetching plan details:', error);
    }
};

const goBack = () => {
    window.history.back();
};

onMounted(() => {
    fetchPlanDetails();
});
</script>

<style scoped>
.training-day {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    font-weight: bold;
}

button {
    margin-top: 10px;
    cursor: pointer;
}
</style>
