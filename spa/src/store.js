import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAppStore = defineStore('app', () => {

    const user = ref(null)
    const password = ref(null)

    return {user, password}
    
})
