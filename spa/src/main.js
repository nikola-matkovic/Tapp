import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from "./Router"
import  {createPinia}  from 'pinia'

let app = createApp(App);
const pinia = createPinia();
app.use(pinia)
app.use(router)

app.mount('#app')
