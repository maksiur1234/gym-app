<template>
    <div class="p-6 max-w-3xl mx-auto shadow-lg rounded-lg border">
        <h2 class="text-2xl font-bold mb-6">Konfiguracja Planu Treningowego</h2>

        <!-- Nazwa planu -->
        <div class="mb-6">
            <label for="planName" class="block text-lg font-semibold mb-2">Nazwa planu</label>
            <InputText id="planName" v-model="planName" class="w-full p-3 border rounded-lg shadow-sm" />
        </div>

        <!-- Opis planu -->
        <div class="mb-6">
            <FloatLabel>
                <Textarea v-model="planDesc" rows="5" cols="30" class="w-full p-3 border rounded-lg shadow-sm"/>
                <label>Ogólny opis planu treningowego. Cele, założenia itp.</label>
            </FloatLabel>
        </div>

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
const planName = inject('planName');
const planDesc = inject('planDesc');

</script>

<style scoped>
</style>
