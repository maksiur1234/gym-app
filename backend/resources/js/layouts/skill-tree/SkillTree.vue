<template>
    <Card> 
        <template #title>
            <div class="main mb-2">
                <Button as="a" label="Wróć" href="/dashboard" rel="noopener" class="rounded-lg bg-gradient-to-br from-primary-400 to-primary-700 active:from-primary-700 active:to-primary-900 text-white border-none px-6 py-3 font-bold hover:ring-2 cursor-pointer ring-offset-2 ring-offset-surface-0 dark:ring-offset-surface-900 ring-primary transition-all" />
            </div>
        </template>

        <template #content>
            <OrganizationChart v-model:selectionKeys="selection" :value="treeData" collapsible selectionMode="multiple">
                <template #cali="slotProps">
                    <div class="flex flex-col items-center p-4 border-b border-gray-200">
                        <img :alt="slotProps.node.data.name" :src="slotProps.node.data.image" class="mb-4 w-16 h-16 rounded-full shadow-md" />
                        <span class="text-xl font-bold mb-1">{{ slotProps.node.data.name }}</span>
                        <span class="text-sm text-white-500">{{ slotProps.node.data.title }}</span>
                    </div>
                </template>
                
                <template #default="slotProps">
                    <div class="flex flex-col p-4 rounded-lg shadow-md mb-4">
                        <span class="text-lg font-bold mb-2">{{ slotProps.node.label }}</span>
                        
                        <div class="text-sm font-medium flex items-center">
                            <span class="inline-block px-2 py-1 rounded-full mr-2">
                                Poziom: {{ slotProps.node.level }}
                            </span>
                        </div>
                            <p class="mt-2 leading-relaxed">{{ slotProps.node.desc }}</p>
                        <Button label="Szczegóły" @click="visible = true" />
                        <Dialog v-model:visible="visible" modal header="Opis ćwiczenia" :style="{ width: '75rem' }">
                            <p class="mt-2  leading-relaxed">{{ slotProps.node.desc }}</p>
                        </Dialog>
                    </div>
                </template>
            </OrganizationChart>
        </template>
    </Card>
</template>

<script setup>
import { ref } from "vue";
import { data } from "../../sections/skill-tree/data";
const visible = ref(false);
const treeData = ref(data);

const selection = ref({});
</script>