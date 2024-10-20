<template>
    <div class="flex">
      <!-- Sidebar -->
      <div class="sidebar flex flex-col h-screen w-64 bg-white dark:bg-gray-800 shadow-lg">
        <div class="flex items-center justify-between px-6 py-4 shrink-0">
          <span class="inline-flex items-center gap-2">
            <svg width="35" height="40" viewBox="0 0 35 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M25.87 18.05L23.16 17.45L25.27 20.46V29.78L32.49 23.76V13.53L29.18 14.73L25.87 18.04V18.05ZM25.27 35.49L29.18 31.58V27.67L25.27 30.98V35.49ZM20.16 17.14H20.03H20.17H20.16ZM30.1 5.19L34.89 4.81L33.08 12.33L24.1 15.67L30.08 5.2L30.1 5.19ZM5.72 14.74L2.41 13.54V23.77L9.63 29.79V20.47L11.74 17.46L9.03 18.06L5.72 14.75V14.74ZM9.63 30.98L5.72 27.67V31.58L9.63 35.49V30.98ZM4.8 5.2L10.78 15.67L1.81 12.33L0 4.81L4.79 5.19L4.8 5.2ZM24.37 21.05V34.59L22.56 37.29L20.46 39.4H14.44L12.34 37.29L10.53 34.59V21.05L12.42 18.23L17.45 26.8L22.48 18.23L24.37 21.05ZM22.85 0L22.57 0.69L17.45 13.08L12.33 0.69L12.05 0H22.85Z"
                fill="var(--p-primary-color)"
              />
              <path
                d="M30.69 4.21L24.37 4.81L22.57 0.69L22.86 0H26.48L30.69 4.21ZM23.75 5.67L22.66 3.08L18.05 14.24V17.14H19.7H20.03H20.16H20.2L24.1 15.7L30.11 5.19L23.75 5.67ZM4.21002 4.21L10.53 4.81L12.33 0.69L12.05 0H8.43002L4.22002 4.21H4.21002ZM21.9 17.4L20.6 18.2H14.3L13 17.4L12.4 18.2L12.42 18.23L17.45 26.8L22.48 18.23L22.5 18.2L21.9 17.4ZM4.79002 5.19L10.8 15.7L14.7 17.14H14.74H15.2H16.85V14.24L12.24 3.09L11.15 5.68L4.79002 5.2V5.19Z"
                fill="var(--p-text-color)"
              />
            </svg>
            <span class="font-semibold text-2xl text-primary">GymApp</span>
          </span>
        </div>
        <div class="overflow-y-auto flex-1">
          <ul class="list-none p-4 m-0">
            <li>
              <div
                v-ripple
                @click="toggleFav"
                v-styleclass="{
                  selector: '@next',
                  enterFromClass: 'hidden',
                  enterActiveClass: 'animate-slidedown',
                  leaveToClass: 'hidden',
                  leaveActiveClass: 'animate-slideup'
                }"
                class="p-4 flex items-center justify-between text-surface-500 dark:text-surface-400 cursor-pointer p-ripple"
              >
                <span class="font-medium">ULUBIONE</span>
                <i class="pi pi-chevron-down" :class="{ 'rotate-180': isOpenFav }"></i>
              </div>
              <ul class="list-none p-0 m-0 overflow-hidden" v-show="isOpenFav">
                <li>
                  <a v-ripple href='/dashboard' class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                    <i class="pi pi-home mr-2"></i>
                    <span class="font-medium">Strona główna</span>
                  </a>
                </li>
                <li>
                  <a v-ripple href="/training-plans" class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                    <i class="pi pi-bookmark mr-2"></i>
                    <span class="font-medium">Twoje plany treningowe</span>
                  </a>
                </li>
                  <li>
                      <a v-ripple href="/users" class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                          <i class="pi pi-user mr-2"></i>
                          <span class="font-medium">Uzytkownicy</span>
                      </a>
                  </li>
                  <li>
                      <a v-ripple href="/trainers" class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                          <i class="pi pi-users mr-2"></i>
                          <span class="font-medium">Trenerzy</span>
                      </a>
                  </li>
                <li>
                  <a href="/all-chats" v-ripple class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                    <i class="pi pi-comments mr-2"></i>
                    <span class="font-medium">Czat</span>
                  </a>
                </li>
                <li>
                  <a v-ripple href="/schedule" class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                    <i class="pi pi-calendar mr-2"></i>
                    <span class="font-medium">Harmonogram</span>
                  </a>
                </li>
                <!--<li>
                  <a v-ripple class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                    <i class="pi pi-cog mr-2"></i>
                    <span class="font-medium">Ustawienia</span>
                  </a>
                </li>
                  <li>
                      <a v-ripple href="/ready-training-plans" class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                          <i class="pi pi-globe mr-2"></i>
                          <span class="font-medium">Gotowe plany treningowe</span>
                      </a>
                  </li>
                  <li>
                      <a v-ripple href="/journal" class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                          <i class="pi pi-book mr-2"></i>
                          <span class="font-medium">Dziennik treningowy</span>
                      </a>
                  </li> -->
                  <!-- <li>
                      <a v-ripple href="/skill-tree" class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                          <i class="pi pi-chart-line mr-2"></i>
                          <span class="font-medium">Drzewo rozwoju</span>
                      </a>
                  </li> -->
                  <!-- <li>
                      <a v-ripple href="/achivments" class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
                          <i class="pi pi-star-fill mr-2"></i>
                          <span class="font-medium">Osiągnięcia</span>
                      </a>
                  </li> -->
              </ul>
            </li>
          </ul>
          <ul class="list-none p-4 m-0">
            <li>
              <div
                v-ripple
                @click="toggleAcc"
                v-styleclass="{
                  selector: '@next',
                  enterFromClass: 'hidden',
                  enterActiveClass: 'animate-slidedown',
                  leaveToClass: 'hidden',
                  leaveActiveClass: 'animate-slideup'
                }"
                class="p-4 flex items-center justify-between text-surface-500 dark:text-surface-400 cursor-pointer p-ripple"
              >
                <span class="font-medium">APLIKAJCA</span>
                <i class="pi pi-chevron-down" :class="{ 'rotate-180': isOpenAcc }"></i>
              </div>
              <ul
                v-show="isOpenAcc"
                class="list-none p-0 m-0 overflow-hidden transition-all duration-400 ease-in-out"
              >
                <li>
                  <a
                    v-ripple
                    href ='/ready-training-plans'
                    class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                  >
                    <i class="pi pi-folder mr-2"></i>
                    <span class="font-medium">Gotowe plany treningowe</span>
                  </a>
                </li>
                <li>
                  <a
                    v-ripple
                    class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                  >
                    <i class="pi pi-chart-bar mr-2"></i>
                    <span class="font-medium">Statystyki</span>
                  </a>
                </li>
                <li>
                  <a
                    v-ripple
                    class="flex items-center cursor-pointer p-4 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple"
                  >
                    <i class="pi pi-cog mr-2"></i>
                    <span class="font-medium">Ustawienia</span>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <div class="mt-auto">
          <hr class="mb-4 mx-4 border-t border-0 border-surface-200 dark:border-surface-700" />
          <a v-ripple href="/user/profile" class="m-4 flex items-center cursor-pointer p-4 gap-2 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
            <Avatar image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" shape="circle" />
            <span class="font-bold">User</span>
          </a>
        </div>
          <div class="m-4 flex items-center cursor-pointer p-4 gap-2 rounded text-surface-700 hover:bg-surface-100 dark:text-surface-0 dark:hover:bg-surface-800 duration-150 transition-colors p-ripple">
              <i class="pi pi-sign-out mr-2"></i>
              <button @click="logout">Wyloguj</button>
          </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  const isOpenAcc = ref(true);
  const isOpenFav = ref(true);

  const toggleFav = () => {
    isOpenFav.value = !isOpenFav.value;
  }

  const toggleAcc = () => {
    isOpenAcc.value = !isOpenAcc.value;
  }

  const logout = async () => {
      try {
          const response = await fetch('/logout', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
          });

          if (response.ok) {
              window.location.href = '/login';
          } else {
              alert('Logout failed');
          }
      } catch (error) {
          console.error('Error:', error);
      }
  }
  </script>

  <style scoped>
  .rotate-180 {
    transform: rotate(180deg);
  }
  </style>
