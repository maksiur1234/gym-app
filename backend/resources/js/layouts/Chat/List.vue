<template>
    <div class="flex justify-center items-center min-h-screen w-full">
        <Card class="max-w-md w-full">
            <template #title>Twoje czaty</template>
            <template #content>
                <div class="flex flex-col mb-2">
                    <a href="/global-chat">Czat Globalny</a>
                    <a :href="`/chat/${id}`">Czat z trenerem: nazwa</a>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
</script>

<style scoped>
</style>
