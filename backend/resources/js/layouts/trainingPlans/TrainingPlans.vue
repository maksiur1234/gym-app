<template>
    <div class="flex justify-center items-center min-h-screen">
      <Card class="max-w-md w-full">
        <template #content>
            <div class="main mb-2">
                <Button as="a" label="Wróć" href="/dashboard" rel="noopener" class="rounded-lg bg-gradient-to-br from-primary-400 to-primary-700 active:from-primary-700 active:to-primary-900 text-white border-none px-6 py-3 font-bold hover:ring-2 cursor-pointer ring-offset-2 ring-offset-surface-0 dark:ring-offset-surface-900 ring-primary transition-all" />
                <Button as="a" label="Stwórz plan treningowy" href="/new-training-plan" rel="noopener" class="rounded-lg ml-2 bg-gradient-to-br from-primary-400 to-primary-700 active:from-primary-700 active:to-primary-900 text-white border-none px-6 py-3 font-bold hover:ring-2 cursor-pointer ring-offset-2 ring-offset-surface-0 dark:ring-offset-surface-900 ring-primary transition-all" />
            </div>
            <div class="main mb-2">
                <h1>Przeglądaj swoje plany treningowe!</h1>
            </div>
            <hr>
          <div class="main mb-2">
              <UserPlans />
          </div>
        </template>
      </Card>
    </div>
  </template>

  <script setup>
  import UserPlans from "@/layouts/trainingPlans/UserPlans.vue";

  </script>

  <style scoped>
  .max-w-md {
    max-width: 88rem;
  }

  .main {
    min-width: 80rem;
  }

  </style>
