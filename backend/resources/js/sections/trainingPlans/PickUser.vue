<template>
    <div class="p-4 mx-auto shadow-lg rounded-lg border mb-4 max-w-lg">
        <h2 class="text-xl font-semibold mb-4">Wybierz użytkownika</h2>
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
</template>

<script setup>
import { ref, onMounted, defineEmits } from 'vue';
import axios from 'axios';

const emit = defineEmits(['update:selectedUser']);
const selectedUser = ref(null);
const users = ref([]);

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
</script>

<style scoped>
/* Custom styles for better appearance */
</style>
