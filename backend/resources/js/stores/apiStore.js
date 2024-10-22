import { defineStore } from 'pinia';
import axios from 'axios';

export const useApiStore = defineStore('api', {
    state: () => ({
        user: JSON.parse(localStorage.getItem('userData')) || null, 
        loading: false,
        error: null,
    }),

    actions: {
        async fetchUserData() {
            this.loading = true;
            this.error = null;

            try {
                if (!this.user) {
                    const response = await axios.get('/fetch-user-data');
                    this.user = response.data;

                    localStorage.setItem('userData', JSON.stringify(this.user));
                }
            } catch (error) {
                this.error = 'Failed to fetch user data';
            } finally {
                this.loading = false;
            }
        },
    },
});
