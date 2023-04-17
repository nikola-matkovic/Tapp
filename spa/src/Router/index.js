import {createRouter, createWebHashHistory} from 'vue-router'
import Home from "../View/Home.vue"

const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHashHistory(),
    routes : [
        {path : "/", component: Home}
    ]
})

export default router;