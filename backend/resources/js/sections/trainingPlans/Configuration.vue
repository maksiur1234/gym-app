<template>
    <div class="p-6 max-w-3xl mx-auto shadow-lg rounded-lg border">
        <h2 class="text-2xl font-bold mb-6">Konfiguracja Planu Treningowego</h2>

        <!-- Nazwa planu -->
        <div class="mb-6">
            <label for="planName" class="block text-lg font-semibold mb-2">Nazwa planu</label>
            <InputText id="planName" v-model="name" class="w-full p-3 border rounded-lg shadow-sm" />
        </div>

        <!-- Opis planu -->
        <div class="mb-6">
            <FloatLabel>
                <Textarea v-model="desc" rows="5" cols="30" class="w-full p-3 border rounded-lg shadow-sm"/>
                <label>Ogólny opis planu treningowego. Cele, założenia itp.</label>
            </FloatLabel>
        </div>

        <!-- Rozplanowanie treningów -->
        <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">Rozplanowanie treningów</label>
            <p class="mb-2">Podaj ilość jednostek treningowych w tygodniu.</p>
            <InputNumber
                v-model="trainingDays"
                showButtons
                buttonLayout="vertical"
                style="width: 4rem"
                :min="0"
                :max="99"
                class="w-full p-3 border rounded-lg shadow-sm"
            >
                <template #incrementbuttonicon>
                    <span class="pi pi-plus" />
                </template>
                <template #decrementbuttonicon>
                    <span class="pi pi-minus" />
                </template>
            </InputNumber>
        </div>
    </div>
</template>

<script setup>
import { inject, ref } from 'vue';

const trainingDays = inject('trainingDays');
const setTrainingDays = inject('setTrainingDays');
const name = inject('name');
const setName = inject('setName');
const desc = inject('desc');
const setDesc = inject('setDesc');

const updateTrainingDays = () => {
    setTrainingDays(trainingDays.value);
    setName(name.value);
    setDesc(desc.value);
};
</script>

<style scoped>
/* Additional styles if necessary */
</style>
