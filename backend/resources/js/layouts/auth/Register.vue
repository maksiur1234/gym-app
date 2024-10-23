<template>
    <div class="flex flex-col justify-center items-center min-h-screen">
        <RegisterStepper />

        <div class="mt-4 text-center">
            <p class="text-gray-600">Masz już konto?</p>
            <a href="/login" class="text-green-500 hover:underline">
                Zaloguj się
            </a>
        </div>
    </div>
</template>

<script setup>
import RegisterStepper from "@/sections/auth/RegisterStepper.vue";
</script>
