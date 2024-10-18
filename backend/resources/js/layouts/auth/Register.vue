<template>
    <div class="relative h-screen">
        <Splitter style="height: 950px">
            <SplitterPanel class="flex items-center justify-center border" :size="65">
                <RegisterStepper />
            </SplitterPanel>
        </Splitter>
    </div>
</template>

<script setup>
import RegisterStepper from "@/sections/auth/RegisterStepper.vue";
</script>

<style scoped>
.relative {
    position: relative;
}

.absolute {
    position: absolute;
}

.inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

.object-cover {
    object-fit: cover;
}

.h-screen {
    height: 100vh;
}
</style>
