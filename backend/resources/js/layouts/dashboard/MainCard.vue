<template>
  <div class="flex justify-center items-center min-h-screen">
    <Card class="max-w-md w-full">
      <template #title>Hej maksi rozpocznij trening klikając w przycisk!</template>
      <template #content>
        <div class="main mb-2">
          <Button label="Wyświetl aktualny plan treningowy"/>
            <Button @click="toggleTraining" :label="isTrainingActive ? 'Zakończ trening' : 'Rozpocznij trening'" class="ml-2 mb-4"/>
            <CurrentTrainingCard v-if="isTrainingActive"/>
        </div>
        <div class="mb-2 ">
          <BasicInfo />
        </div>
        <div class="mb-2">
          <BasicSchedule />
        </div>
        <div class="mb-2">
          <BasicStatistics />
        </div>
      </template>
    </Card>
  </div>
</template>
  
<script setup>
import BasicInfo from '../../sections/dashboard/BasicInfo.vue';
import BasicSchedule from '../../sections/dashboard/BasicSchedule.vue';
import BasicStatistics from '../../sections/dashboard/BasicStatistics.vue';
import CurrentTrainingCard from '../../sections/training/CurrentTrainingCard.vue';

import { ref } from 'vue';

const isTrainingActive = ref(false);

const toggleTraining = () => {
  isTrainingActive.value = !isTrainingActive.value;
}

</script>

<style scoped>
.max-w-md {
  max-width: 88rem;
}

.main {
  min-width: 80rem;
}

</style>
