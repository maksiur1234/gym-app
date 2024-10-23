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

            <div class="flex justify-between items-center mt-4">
                <button
                    @click="previousPage"
                    :disabled="currentPage === 1"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50"
                >
                    Poprzednia
                </button>
                <span>Strona {{ currentPage }} z {{ totalPages }}</span>
                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50"
                >
                    Następna
                </button>
            </div>
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

const currentPage = ref(1);
const totalPages = ref(); 

const fetchUsers = async () => {
    try {
        const response = await axios.get(`/all-users?page=${currentPage.value}`);
        users.value = response.data.data;
        totalPages.value = response.data.meta.last_page; 
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

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        fetchUsers();
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        fetchUsers();
    }
};
</script>
