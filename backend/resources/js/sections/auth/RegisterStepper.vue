
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
                    </div>
                    <div class="flex pt-6 justify-end">
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="activateCallback(2)" />
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
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback(1)" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="activateCallback(3)" />
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
                    </div>
                    <div class="flex pt-6 justify-between">
                        <Button label="Cofnij" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback(2)" />
                        <Button label="Dalej" icon="pi pi-arrow-right" iconPos="right" @click="activateCallback(4)" />
                    </div>
                </StepPanel>

                <StepPanel v-slot="{ activateCallback }" :value="4">
                    <div class="flex flex-col gap-2 mx-auto" style="min-height: 16rem; max-width: 24rem">
                        <div class="text-center mt-4 mb-4 text-xl font-semibold">Zarejestruj się!</div>
                        <div class="text-center">
                            <img alt="logo" src="https://primefaces.org/cdn/primevue/images/stepper/content.svg" />
                        </div>
                    </div>
                    <div class="flex pt-6 justify-start">
                        <Button label="Zarejestruj" icon="pi pi-arrow-right" iconPos="right" @click="saveUser" />
                    </div>
                </StepPanel>
            </StepPanels>
        </Stepper>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from "axios";

const userData = ref({
    name: '',
    surname: '',
    email: '',
    password: '',
    weight: '',
    height: '',
    age: '',
    training_intership: '',
    desc: ''
});
const saveUser = async () => {
    try {
        console.log(userData.value);
        await axios.post('/save-user', userData.value);

    } catch (error) {
        console.error(error);
    }
}

const customBase64Uploader = async (event) => {
    const file = event.files[0];
    const reader = new FileReader();
    let blob = await fetch(file.objectURL).then((r) => r.blob()); //blob:url

    reader.readAsDataURL(blob);

    reader.onloadend = function () {
        const base64data = reader.result;
    };
};

const activeStep = ref(1);
const completed = ref(false);
const products = ref();
const name = ref();
const email = ref();
const password = ref();
const option1 = ref(false);
const option2 = ref(false);
const option3 = ref(false);
const option4 = ref(false);
const option5 = ref(false);
const option6 = ref(false);
const option7 = ref(false);
const option8 = ref(false);
const option9 = ref(false);
const option10 = ref(false);

</script>
