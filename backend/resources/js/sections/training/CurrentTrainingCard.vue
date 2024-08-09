
<template>
    <Card style="width: 25rem; overflow: hidden">
        <template #header>
            <img alt="user header" src="https://gymrage.pl/wp-content/uploads/wyciskanie-sztangi-lezac-prawidlowy-chwyt-gryfu.jpg" />
        </template>
        <template #title>Trening siłowy</template>
        <template #subtitle>Plan dla kultursty v2</template>
        <template #content>
            <p class="m-0">
                Czas trwania treningu:
            </p>
            <p class="m-0">
                Aktulne ćwiczenie:
            </p>
            <p class="m-0">
                Następne ćwiczenie:
            </p>
            <p class="m-0">
                Notatka od trenera odnośnie aktualnego ćwiczenia:
            </p>
            <p class="m-0">
                Twoja notatka odnośnie aktualnego ćwiczenia:
            </p>
        </template>
        <template #footer>
            <div class="flex gap-4 mt-1">
                <Button label="Dodaj notatke dla aktualnego ćwiczenia" severity="secondary" outlined class="w-full" />
                <Button label="Przejdź do następnego ćwiczenia dzisiaj" class="w-full" />
            </div>
        </template>
    </Card>
</template>

<script setup>
</script>
