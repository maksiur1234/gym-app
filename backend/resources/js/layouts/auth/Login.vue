<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-800">
        <Card class="shadow-lg h-auto w-1/2 max-w-md p-6">
            <template #header>
                <div class="flex justify-center mb-4">
                    <img alt="user header" class="rounded-full h-24 w-24" src="https://img.freepik.com/premium-vector/gym-logo-muscle-logo-muscle-training-logo-muscle-development-center-logo-body-building-logo_848918-3459.jpg?size=338&ext=jpg&ga=GA1.1.1413502914.1725148800&semt=ais_hybrid" />
                </div>
            </template>
            <template #title>
                <div class="flex justify-center text-xl font-semibold">
                    Witaj w GymApp!
                </div>
            </template>
            <template #subtitle>
                <hr class="w-60 h-1 mx-auto my-4 bg-gray-300 border-0 rounded dark:bg-gray-700">
            </template>
            <template #content>
                <div class="flex flex-col gap-4">
                    <div v-if="generalError" class="text-red-600 text-center">
                        {{ generalError }}
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <label for="email" class="font-medium">Email</label>
                        <InputText id="email" v-model="email" aria-describedby="email-help" class="p-2 border rounded" />
                        <small v-if="errors.email" class="text-red-600">{{ errors.email }}</small>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="password" class="font-medium">Hasło</label>
                        <InputText id="password" v-model="password" type="password" aria-describedby="password-help" class="p-2 border rounded" />
                        <small v-if="errors.password" class="text-red-600">{{ errors.password }}</small>
                        <small id="password-help" class="text-right text-sm text-gray-500">Zapomniałeś hasła?</small>
                    </div>
                    <div class="flex items-center">
                        <Checkbox v-model="remember" inputId="ingredient1" name="remember" value="remember" />
                        <label for="ingredient1" class="ml-2"> Zapamiętaj mnie </label>
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-4 mt-4">
                    <Button label="Zaloguj się" class="w-full" @click="handleSubmit" />
                </div>
                <div class="flex justify-center mt-2 text-sm text-gray-600">
                    Nie masz konta? <a href="/register" class="text-blue-600 hover:underline">Zarejestruj się!</a>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const email = ref('');
const password = ref('');
const remember = ref(false);
const errors = ref({
    email: '',
    password: ''
});
const generalError = ref('');

const validateForm = () => {
    let valid = true;
    errors.value.email = '';
    errors.value.password = '';
    generalError.value = '';  

    if (!email.value) {
        errors.value.email = 'Email jest wymagany.';
        valid = false;
    }

    if (!password.value) {
        errors.value.password = 'Hasło jest wymagane.';
        valid = false;
    }

    return valid;
};

const handleSubmit = async () => {
    if (validateForm()) {
        try {
            const response = await axios.post('/login', {
                email: email.value,
                password: password.value,
            });
            window.location.href = '/dashboard';
        } catch (error) {
            generalError.value = 'Niepoprawny email lub hasło. Spróbuj ponownie.';
            console.error('Błąd logowania:', error);
        }
    }
};
</script>

<style scoped>
.min-h-screen {
    min-height: 100vh;
}

.shadow-lg {
    border-radius: 8px;
    padding: 20px;
}

img.rounded-full {
    object-fit: cover;
}
</style>
