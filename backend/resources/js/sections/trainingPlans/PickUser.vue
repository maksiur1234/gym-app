<template>
    <div class="p-4 mx-auto shadow-lg rounded-lg border mb-4 max-w-lg">
        <h2 class="text-xl font-semibold mb-4">Wybierz użytkownika lub stwórz gotowy plan dla wszystkich</h2>

        <div class="mb-4">
            <input type="checkbox" v-model="isPublic" id="globalCheck" @change="onGlobalChange" />
            <label for="globalCheck" class="ml-2 text-lg font-semibold">Stwórz plan dla wszystkich</label>
        </div>

        <div v-if="!isPublic">
            <Listbox v-model="selectedUser" :options="users" filter optionLabel="name" @change="onUserChange">
                <template #option="{ option }">
                    <div class="flex items-center p-2">
                        <img :src="option.profile_photo_path" alt="Profile Photo" class="w-16 h-16 rounded-full shadow-lg mr-4"/>
                        <div>
                            <span class="font-semibold text-lg">{{ option.name }} {{ option.surname }}</span>
                        </div>
                    </div>
                </template>
            </Listbox>
        </div>
    </div>
</template>


<script setup>
import { ref, onMounted, defineEmits } from 'vue';
import axios from 'axios';

const emit = defineEmits(['update:selectedUser', 'update:isPublic']);
const selectedUser = ref(null);
const users = ref([]);
const isPublic = ref(false);

const fetchUsers = async () => {
    try {
        const response = await axios.get('/all-users');
        users.value = response.data.data;
    } catch (error) {
        console.error('Error fetching users:', error);
    }
};

onMounted(() => {
    fetchUsers();
});

const onUserChange = () => {
    emit('update:selectedUser', selectedUser.value);
};

const onGlobalChange = () => {
    if (isPublic.value) {
        selectedUser.value = null;
        emit('update:selectedUser', null);
    }
    emit('update:isPublic', isPublic.value);
};

</script>
