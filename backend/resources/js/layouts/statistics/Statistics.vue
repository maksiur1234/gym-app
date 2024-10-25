<template>
    <div class="flex flex-col justify-center items-center min-h-screen">
        <Card class="max-w-md w-full mb-4">
            <template #content>
                <div class="main mb-2">
                    <Button as="a" label="Wróć" href="/dashboard" rel="noopener" class="rounded-lg bg-gradient-to-br from-primary-400 to-primary-700 active:from-primary-700 active:to-primary-900 text-white border-none px-6 py-3 font-bold hover:ring-2 cursor-pointer ring-offset-2 ring-offset-surface-0 dark:ring-offset-surface-900 ring-primary transition-all" />

                </div>
                <div class="main mb-2">
                    <h1>Statystyki</h1>
                </div>
                <hr>
                <div class="main mb-2">
                    <StatisticsDetails />
                </div>
                
            </template>
        </Card>
        <Card class="m-2">
            <template #content>
            <div class="main flex flex-col">
                <StatisticsChart />
            </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import StatisticsDetails from '../../sections/statistics/StatisticsDetails.vue';
import StatisticsChart from '../../sections/statistics/StatisticsChart.vue';
</script>

<style scoped>
.max-w-md {
    max-width: 88rem;
}

.main {
    min-width: 80rem;
}

</style>
