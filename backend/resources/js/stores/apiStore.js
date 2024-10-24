import { defineStore } from 'pinia';
import axios from 'axios';

function safeParse(jsonString) {
    try {
        return JSON.parse(jsonString);
    } catch (error) {
        console.error('Błąd podczas parsowania JSON:', error);
        return null;
    }
}

export const useApiStore = defineStore('api', {
    state: () => ({
        user: safeParse(sessionStorage.getItem('user')) || null, 
        plan: safeParse(sessionStorage.getItem('defaultPlan')) || null, 
        loading: false,
        error: null,
    }),

    actions: {
        async fetchUserData() {
            const storedUser = sessionStorage.getItem('user');
            if (storedUser) {
                this.user = safeParse(storedUser);  
                return;  
            }

            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get('/fetch-user-data');
                this.user = response.data.user;  
                sessionStorage.setItem('user', JSON.stringify(this.user));  
            } catch (error) {
                this.error = 'Failed to fetch user data';
            } finally {
                this.loading = false;
            }
        },

        async fetchDefaultPlan() {
            const storedDefaultPlan = sessionStorage.getItem('defaultPlan');
            if (storedDefaultPlan) {
                this.plan = safeParse(storedDefaultPlan);
                return;
            }

            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get('/user/get-default-plan');
                this.plan = response.data; 
                sessionStorage.setItem('defaultPlan', JSON.stringify(this.plan)); 
            } catch (error) {
                this.error = 'Failed to fetch default plan';
            } finally {
                this.loading = false;
            }
        },

        clearUserData() {
            this.user = null;  
            sessionStorage.removeItem('user');  
        },

        clearDefaultPlan() {
            this.plan = null;
            sessionStorage.removeItem('defaultPlan');
        }
    },
});
