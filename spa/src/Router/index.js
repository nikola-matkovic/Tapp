import {createRouter, createWebHashHistory} from 'vue-router'
import Home from "../View/Home.vue"
import Settings from "../View/Settings.vue"

const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHashHistory(),
    routes : [
        {path : "/", component: Home},
        {path : "/settings", component: Settings}
    ]
})

export default router;