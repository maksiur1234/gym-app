<template>
    <div class="card flex justify-center">
        <Stepper value="1" class="basis-[50rem]">
            <StepList>
                <Step value="1">Wybierz użytkownika</Step>
                <Step value="2">Konfiguracja planu</Step>
                <Step value="3">Kreator planu treningowego</Step>
                <Step value="4">Dodatkowe informacje</Step>
                <Step value="5">Podsumowanie</Step>
            </StepList>
            <StepPanels>
                <StepPanel v-slot="{ activateCallback }" value="1">
                    <div class="flex flex-col h-48">
                        <PickUser @update:selected-user="handleUserChange" />
                    </div>
                    <div class="p-6 max-w-3xl mx-auto shadow-lg rounded-lg border border-gray-200">
                        <div v-if="selectedUser">
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
                        <div v-else>
                            <p>Wybierz użytkownika, aby wyświetlić jego szczegóły.</p>
                        </div>
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback('1')" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="validateStep1(activateCallback)" />
                    </div>
                    <div v-if="errors.length" class="text-red-500">
                        <ul>
                            <li v-for="error in errors" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                </StepPanel>
                <StepPanel v-slot="{ activateCallback }" value="2">
                    <div class="flex flex-col h-48">
                        <Configuration />
                    </div>
                    <div v-if="errors.length" class="text-red-500">
                        <ul>
                            <li v-for="error in errors" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback('1')" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="validateStep2(activateCallback)" />
                    </div>
                </StepPanel>
                <StepPanel v-slot="{ activateCallback }" value="3">
                    <div class="flex flex-col h-48">
                        <Creator />
                    </div>
                    <div v-if="errors.length" class="text-red-500">
                        <ul>
                            <li v-for="error in errors" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback('2')" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="validateStep3(activateCallback)" />
                    </div>
                </StepPanel>
                <StepPanel v-slot="{ activateCallback }" value="4">
                    <div class="flex flex-col h-48">
                        <AdditionalInfo />
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback('3')" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="activateCallback('5')"/>
                    </div>
                </StepPanel>
                <StepPanel v-slot="{ activateCallback }" value="5">
                    <div class="flex flex-col h-48">
                        <Summary />
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback('4')" />
                        <Button label="Zapisz plan" icon="pi pi-arrow-right" iconPos="right" @click="savePlan" />
                    </div>
                </StepPanel>
            </StepPanels>
        </Stepper>
    </div>
</template>

<script setup>
import { ref, provide, onMounted } from 'vue';
import axios from 'axios';

import Configuration from "@/sections/trainingPlans/Configuration.vue";
import PickUser from "@/sections/trainingPlans/PickUser.vue";
import Creator from "@/sections/trainingPlans/Creator.vue";
import AdditionalInfo from "@/sections/trainingPlans/AdditionalInfo.vue";
import Summary from "@/sections/trainingPlans/Summary.vue";

const selectedUser = ref(null);
const isPublic = ref(false);
const trainingDays = ref([]);
const planName = ref('');
const planDesc = ref('');
const additionalInfo = ref('');
const rows = ref({});
const created_by = ref('');
const price = ref([]);
const errors = ref([]);

const handleUserChange = (user) => {
    selectedUser.value = user;
    isPublic.value = user === null;
};

provide('selectedUser', selectedUser);
provide('isPublic', isPublic);
provide('trainingDays', trainingDays);
provide('planName', planName);
provide('planDesc', planDesc);
provide('additionalInfo', additionalInfo);
provide('rows', rows);
provide('price', price);

const validateStep1 = (activateCallback) => {
    errors.value = [];
    if (!selectedUser.value && !isPublic.value) {
        errors.value.push('Wymagane jest wybranie użytkownika lub opcji tworzenia planu dla wszystkich');
    }
    if (errors.value.length === 0) {
        activateCallback('2');
    }
};

const validateStep2 = (activateCallback) => {
    errors.value = [];
    if (planName.value.trim().length === 0) errors.value.push('Nazwa planu jest wymagana.');
    if (planDesc.value.trim().length === 0) errors.value.push('Opis planu jest wymagany.');
    if (trainingDays.value.length === 0) errors.value.push('Musi być dodana minimum jedna jednostka treningowa w treningu.');
    
    if (errors.value.length === 0) {
        activateCallback('3');
    }
};

const validateStep3 = (activateCallback) => {
    errors.value = [];
    
    if (rows.value) {
        for (const key in rows.value) {
            if (Array.isArray(rows.value[key]) && rows.value[key].length > 0) {
                rows.value[key].forEach((exercise, index) => {
                    if (!exercise.exercise_name) errors.value.push(`Dzień ${key}, Ćwiczenie ${index + 1}: Nazwa ćwiczenia jest wymagana.`);
                    if (!exercise.sets) errors.value.push(`Dzień ${key}, Ćwiczenie ${index + 1}: Ilość serii jest wymagana.`);
                    if (!exercise.reps) errors.value.push(`Dzień ${key}, Ćwiczenie ${index + 1}: Ilość powtórzeń jest wymagana.`);
                    if (!exercise.rir) errors.value.push(`Dzień ${key}, Ćwiczenie ${index + 1}: RIR jest wymagany.`);
                    if (!exercise.tempo) errors.value.push(`Dzień ${key}, Ćwiczenie ${index + 1}: Tempo jest wymagane.`);
                    if (!exercise.break) errors.value.push(`Dzień ${key}, Ćwiczenie ${index + 1}: Długość przerwy jest wymagana.`);
                });
            } else {
                errors.value.push(`Dzień ${key}: Brak ćwiczeń do walidacji.`);
            }
        }
    } else {
        errors.value.push('Brak danych do walidacji.');
    }

    if (errors.value.length === 0) {
        activateCallback('4');
    }
};

const savePlan = async () => {
    try {
        const planData = {
            user_id: selectedUser.value ? selectedUser.value.id : null,
            created_by: created_by.value,
            is_public: isPublic.value,
            trainingDays: trainingDays.value,
            additionalInfo: additionalInfo.value,
            planName: planName.value,
            planDesc: planDesc.value,
            rows: rows.value,
            price: price.value,
        };

        const url = isPublic.value ? '/store-ready-training-plans' : '/store-training-plans';
        await axios.post(url, planData);

        alert('Plan został zapisany pomyślnie!');
        window.location.href = 'training-plans';
    } catch (error) {
        console.error('Błąd podczas zapisywania planu:', error);
        alert('Wystąpił błąd podczas zapisywania planu.');
    }
};

onMounted(() => {
    const userData = JSON.parse(localStorage.getItem('user'));
    if (userData && userData.id) {
        created_by.value = userData.id.toString();
    }
});
</script>
