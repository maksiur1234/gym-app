<template>
    <div class="p-6 max-w-3xl mx-auto shadow-lg rounded-lg">
        <div v-if="isPublic" class="flex-auto">
            <label for="stacked-buttons" class="font-bold block mb-2"> Cena planu treningowego </label>
            <InputNumber v-model="price" inputId="stacked-buttons" showButtons mode="currency" currency="PLN" fluid />
        </div>
        <div class="card flex justify-center p-2">
            <FloatLabel>
                <Textarea v-model="additionalInfo" rows="5" cols="30" />
                <label>Dodatkowe informacje, opis wyrażeń, porady itp.</label>
            </FloatLabel>
        </div>
    </div>
</template>

<script setup>
import { inject } from 'vue';

const isPublic = inject('isPublic');
const additionalInfo = inject('additionalInfo');
const price = inject('price');

</script>
