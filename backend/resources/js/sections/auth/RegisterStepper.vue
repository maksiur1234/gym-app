
<template>
    <div class="card flex justify-center">
        <Stepper v-model:value="activeStep" class="basis-[80rem]">
            <StepList>
                <Step v-slot="{ activateCallback, value, a11yAttrs }" asChild :value="1">
                    <div class="flex flex-row flex-auto gap-2" v-bind="a11yAttrs.root">
                        <button class="bg-transparent border-0 inline-flex flex-col gap-2" @click="activateCallback" v-bind="a11yAttrs.header">
                            <span
                                :class="[
                                    'rounded-full border-2 w-12 h-12 inline-flex items-center justify-center',
                                    { 'bg-primary text-primary-contrast border-primary': value <= activeStep, 'border-surface-200 dark:border-surface-700': value > activeStep }
                                ]"
                            >
                                <i class="pi pi-user" />
                                
                            </span>
                            <span class="text-center mt-2 font-semibold"v-if="value <= activeStep">Konto</span>
                        </button>
                        <Divider />
                    </div>
                </Step>
                <Step v-slot="{ activateCallback, value, a11yAttrs }" asChild :value="2">
                    <div class="flex flex-row flex-auto gap-2 pl-2" v-bind="a11yAttrs.root">
                        <button class="bg-transparent border-0 inline-flex flex-col gap-2" @click="activateCallback" v-bind="a11yAttrs.header">
                            <span
                                :class="[
                                    'rounded-full border-2 w-12 h-12 inline-flex items-center justify-center',
                                    { 'bg-primary text-primary-contrast border-primary': value <= activeStep, 'border-surface-200 dark:border-surface-700': value > activeStep }
                                ]"
                            >
                                <i class="pi pi-info" />
                            </span>
                            <span class="text-center mt-2 font-semibold"v-if="value <= activeStep">Dane personalne</span>
                        </button>
                        <Divider />
                    </div>
                </Step>
                <Step v-slot="{ activateCallback, value, a11yAttrs }" asChild :value="3">
                    <div class="flex flex-row flex-auto gap-2 pl-2" v-bind="a11yAttrs.root">
                        <button class="bg-transparent border-0 inline-flex flex-col gap-2" @click="activateCallback" v-bind="a11yAttrs.header">
                            <span
                                :class="[
                                    'rounded-full border-2 w-12 h-12 inline-flex items-center justify-center',
                                    { 'bg-primary text-primary-contrast border-primary': value <= activeStep, 'border-surface-200 dark:border-surface-700': value > activeStep }
                                ]"
                            >
                                <i class="pi pi-star" />
                            </span>
                            
                            <span class="text-center mt-2 font-semibold"v-if="value <= activeStep">Doświadczenie</span>
                        </button>
                        <Divider />
                    </div>
                </Step>
                <Step v-slot="{ activateCallback, value, a11yAttrs }" asChild :value="4">
                    <div class="flex flex-row pl-2" v-bind="a11yAttrs.root">
                        <button class="bg-transparent border-0 inline-flex flex-col gap-2" @click="activateCallback" v-bind="a11yAttrs.header">
                            <span
                                :class="[
                                    'rounded-full border-2 w-12 h-12 inline-flex items-center justify-center',
                                    { 'bg-primary text-primary-contrast border-primary': value <= activeStep, 'border-surface-200 dark:border-surface-700': value > activeStep }
                                ]"
                            >
                                <i class="pi pi-id-card" />
                            </span>
                            <span class="text-center mt-2 font-semibold"v-if="value <= activeStep">Podusumowanie</span>
                        </button>
                    </div>
                </Step>
            </StepList>
            <StepPanels>
                <StepPanel v-slot="{ activateCallback }" :value="1">
                    <div class="flex flex-col gap-2 mx-auto" style="min-height: 16rem; max-width: 20rem">
                        <div class="text-center mt-4 mb-4 text-xl font-semibold">Stwórz konto</div>
                        <div class="field">
                            <FileUpload chooseLabel="Wybierz zdjęcie profilowe" mode="basic" name="demo[]" url="/api/upload" accept="image/*" customUpload @uploader="customBase64Uploader" />
                        </div>
                        <div class="field">
                            <InputText id="input" v-model="userData.name" type="text" placeholder="Imię" fluid />
                        </div>
                        <div class="field">
                            <InputText id="input" v-model="userData.surname" type="text" placeholder="Nazwisko" fluid />
                        </div>
                        <div class="field">
                            <InputText id="email" v-model="userData.email" type="email" placeholder="Email" fluid />
                        </div>
                        <div class="field">
                            <Password v-model="userData.password" placeholder="Hasło" fluid />
                        </div>
                        <div class="field">
                            <Password v-model="userData.password_confirmation" placeholder="Potwierdź hasło" fluid />
                        </div>
                        <div v-if="errors.length" class="text-red-500">
                            <ul>
                                <li v-for="error in errors" :key="error">{{ error }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex pt-6 justify-end">
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="validateStep1(activateCallback)" />
                    </div>
                </StepPanel>
                <StepPanel v-slot="{ activateCallback }" :value="2">
                    <div class="flex flex-col gap-2 mx-auto" style="min-height: 16rem; max-width: 20rem">
                        <div class="text-center mt-4 mb-4 text-xl font-semibold">Dane personalne</div>
                        <div class="field">
                            <InputText id="input" v-model="userData.weight" type="text" placeholder="Waga" fluid />
                        </div>
                        <div class="field">
                            <InputText id="input" v-model="userData.height" type="email" placeholder="Wzrost" fluid />
                        </div>
                        <div class="field">
                            <InputText id="input" v-model="userData.age" type="email" placeholder="Wiek" fluid />
                        </div>
                        <div v-if="errors.length" class="text-red-500">
                            <ul>
                                <li v-for="error in errors" :key="error">{{ error }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback(1)" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="validateStep2(activateCallback)" />
                    </div>
                </StepPanel>
                <StepPanel v-slot="{ activateCallback }" :value="3">
                    <div class="flex flex-col gap-2 mx-auto" style="min-height: 16rem; max-width: 20rem">
                        <div class="text-center mt-4 mb-4 text-xl font-semibold">Doświadczenie treningowe</div>
                        <div class="field">
                            <InputText id="input" v-model="userData.training_intership" type="text" placeholder="Doświadczenie treningowe (lata)" fluid />
                        </div>
                        <div class="field">
                            <InputText id="input" v-model="userData.desc" type="email" placeholder="Opisz swoje doświadczenie ile czasu trenujesz itp" fluid />
                        </div>
                        <div v-if="errors.length" class="text-red-500">
                            <ul>
                                <li v-for="error in errors" :key="error">{{ error }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback(2)" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="validateStep3(activateCallback)" />
                    </div>
                </StepPanel>

                <StepPanel v-slot="{ activateCallback }" :value="4">
                    <div class="flex flex-col gap-4 mx-auto" style="min-height: 16rem; max-width: 24rem">
                        <div class="text-center mt-4 mb-4 text-xl font-semibold">Podsumowanie</div>
                        <div class="border rounded-lg p-4 shadow-md">
                            <ul class="list-none space-y-2">
                                <li><strong>Imię:</strong> {{ userData.name }}</li>
                                <li><strong>Nazwisko:</strong> {{ userData.surname }}</li>
                                <li><strong>Email:</strong> {{ userData.email }}</li>
                                <li><strong>Waga:</strong> {{ userData.weight }} kg</li>
                                <li><strong>Wzrost:</strong> {{ userData.height }} cm</li>
                                <li><strong>Wiek:</strong> {{ userData.age }} lat</li>
                                <li><strong>Staż treningowy:</strong> {{ userData.training_intership }}</li>
                                <li><strong>Opis:</strong> {{ userData.desc }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback(3)" />
                        <Button label="Zarejestruj się" icon="pi pi-arrow-right" iconPos="right" @click="saveUser" />
                    </div>
                </StepPanel>
            </StepPanels>
        </Stepper>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from "axios";
import { Role } from '../../enums/Role';

const userData = ref({
    name: '',
    surname: '',
    email: '',
    password: '',
    password_confirmation: '',
    weight: '',
    height: '',
    age: '',
    training_intership: '',
    desc: '',
    role_id: Role.NORMAL,
});

const activeStep = ref(1);
const errors = ref([]);

const validateStep1 = (activateCallback) => {
    errors.value = [];
    if (!userData.value.name) errors.value.push('Imię jest wymagane.');
    if (!userData.value.surname) errors.value.push('Nazwisko jest wymagane.');
    if (!userData.value.email) errors.value.push('Email jest wymagany.');
    if (!userData.value.password) errors.value.push('Hasło jest wymagane.');
    if (userData.value.password !== userData.value.password_confirmation) errors.value.push('Hasła nie pasują.');
    
    if (errors.value.length === 0) {
        activateCallback(2);
    }
};

const validateStep2 = (activateCallback) => {
    errors.value = [];

    if (!userData.value.weight) {
        errors.value.push('Waga jest wymagana.');
    } else if (isNaN(userData.value.weight) || userData.value.weight <= 0) {
        errors.value.push('Waga musi być dodatnią liczbą.');
    }

    if (!userData.value.height) {
        errors.value.push('Wzrost jest wymagany.');
    } else if (isNaN(userData.value.height) || userData.value.height <= 0) {
        errors.value.push('Wzrost musi być dodatnią liczbą.');
    }

    if (!userData.value.age) {
        errors.value.push('Wiek jest wymagany.');
    } else if (isNaN(userData.value.age) || userData.value.age <= 0) {
        errors.value.push('Wiek musi być dodatnią liczbą.');
    }

    if (errors.value.length === 0) {
        activateCallback(3);
    }
};


const validateStep3 = (activateCallback) => {
    errors.value = [];
    if (!userData.value.training_intership) {
        errors.value.push('Doświadczenie treningowe jest wymagane.');
    } else if (isNaN(userData.value.training_intership || userData.value.training_intership <= 0)) {
        errors.value.push('Doświadczenie musi być liczbą.');
    }
    if (!userData.value.desc) errors.value.push('Opis doświadczenia jest wymagany.');
    
    if (errors.value.length === 0) {
        activateCallback(4);
    }
};

const saveUser = async () => {
    try {
        console.log(userData.value);
        await axios.post('/register', userData.value);

        window.location.href = '/dashboard';
    } catch (error) {
        console.error(error);
    }
}

const customBase64Uploader = async (event) => {
    const file = event.files[0];
    const reader = new FileReader();
    let blob = await fetch(file.objectURL).then((r) => r.blob()); 

    reader.readAsDataURL(blob);

    reader.onloadend = function () {
        const base64data = reader.result;
    };
};
</script>
