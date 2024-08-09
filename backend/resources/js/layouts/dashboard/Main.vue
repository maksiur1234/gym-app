<script setup>
import Sidebar from "/resources/js/sections/dashboard/SidebarSection.vue";
</script>

<template>
  <div class="flex">
    <Sidebar class="sidebar" />
  </div>
</template>

<style scoped>
.flex {
  display: flex;
}
.card-section {
  flex-grow: 1;
}
</style>
