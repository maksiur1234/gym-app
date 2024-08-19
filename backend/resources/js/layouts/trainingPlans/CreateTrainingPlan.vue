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
                            <!-- Opcjonalnie, dodaj dodatkowe informacje lub akcje -->
                        </div>
                        <div v-else>
                            <p>Wybierz użytkownika, aby wyświetlić jego szczegóły.</p>
                        </div>
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback('1')" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="activateCallback('2')" />
                    </div>
                </StepPanel>
                <StepPanel v-slot="{ activateCallback }" value="2">
                    <div class="flex flex-col h-48">
                        <Configuration />
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback('1')" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="activateCallback('3')" />
                    </div>
                </StepPanel>
                <StepPanel v-slot="{ activateCallback }" value="3">
                    <div class="flex flex-col h-48">
                        <Creator />
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback('2')" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="activateCallback('4')" />
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
import { ref, provide } from 'vue';
import axios from 'axios';
import Configuration from "@/sections/trainingPlans/Configuration.vue";
import PickUser from "@/sections/trainingPlans/PickUser.vue";
import Creator from "@/sections/trainingPlans/Creator.vue";
import AdditionalInfo from "@/sections/trainingPlans/AdditionalInfo.vue";
import Summary from "@/sections/trainingPlans/Summary.vue";

// Define reactive variables to hold data
const selectedUser = ref();
const trainingDays = ref([]);
const name = ref([]);
const desc = ref([]);
const additionalInfo = ref();
const rows = ref({});

// Handlers
const handleUserChange = (user) => {
    selectedUser.value = user;
};

const saveUser = () => {
    console.log('Zapisano usera: ', selectedUser.value);
};

// Provide the data
provide('selectedUser', selectedUser);
provide('trainingDays', trainingDays);
provide('name', name);
provide('desc', desc);
provide('additionalInfo', additionalInfo);
provide('rows', rows);

// Function to save plan to the server
const savePlan = async () => {
    try {
        // Collect all the data to be sent
        const planData = {
            user: selectedUser.value,
            trainingDays: trainingDays.value,
            additionalInfo: additionalInfo.value
        };
        // Send data to the server
        await axios.post('/store-training-plans', planData);
        alert('Plan został zapisany pomyślnie!');
    } catch (error) {
        console.error('Błąd podczas zapisywania planu:', error);
        alert('Wystąpił błąd podczas zapisywania planu.');
    }
};
</script>
