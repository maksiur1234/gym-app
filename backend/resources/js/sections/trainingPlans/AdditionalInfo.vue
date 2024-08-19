<template>
    <div class="card flex justify-center p-2">
        <FloatLabel>
            <Textarea v-model="additionalInfo" rows="5" cols="30" />
            <label>Dodatkowe informacje, opis wyrażeń, porady itp.</label>
        </FloatLabel>
    </div>
</template>

<script setup>
import {inject, ref} from 'vue';

const additionalInfo = inject('additionalInfo');

</script>
