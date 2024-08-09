<template>
    <div class="card">
        <DataTable
            v-model:editingRows="editingRows"
            :value="users"
            editMode="row"
            dataKey="id"
            @row-edit-save="onRowEditSave"
            :pt="{
                table: { style: 'min-width: 50rem' },
                column: {
                    bodycell: ({ state }) => ({
                        style: state['d_editing'] && 'padding-top: 0.75rem; padding-bottom: 0.75rem'
                    })
                }
            }"
        >
            <Column field="name" header="Nazwisko" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" fluid />
                </template>
            </Column>
            <Column field="surname" header="Nazwisko" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" fluid />
                </template>
            </Column>
            <Column field="role.id" header="Rola" style="width: 20%">
                <template #editor="{ data, field }">
                    <Select v-model="data.role.id" :options="roles" optionLabel="label" optionValue="value" placeholder="Wybierz rolę" fluid />
                </template>
                <template #body="{ data }">
                    {{ data.role.name }}
                </template>
            </Column>
            <Column field="email" header="Email" style="width: 20%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" fluid />
                </template>
            </Column>
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>
        </DataTable>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const users = ref([]);
const editingRows = ref([]);
const roles = ref([]);

const fetchRoles = async () => {
    try {
        const response = await axios.get('/roles');
        roles.value = response.data.map(role => ({
            label: role.name,
            value: role.id
        }));
    } catch (error) {
        console.error(error);
    }
}

const fetchUsers = async () => {
    try {
        const response = await axios.get('/all-users');
        users.value = response.data.data;
    } catch (error) {
        console.error(error);
    }
}

const onRowEditSave = async (event) => {
    let { newData, index } = event;
    try {
        await axios.put(`update-user/${newData.id}`, {
            ...newData,
            role_id: newData.role.id
        });
        users.value[index] = newData;
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    fetchUsers();
    fetchRoles();
});
</script>
