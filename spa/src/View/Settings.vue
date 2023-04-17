<template>
    <div id="settings">
        <h1>Одабери затамљеност</h1>
        <input type="range" name="" id="" min="0" max="100" v-model="opacity">
        <label for="chose-background">
            Одабери Позадину 
        </label>
        <input type="file" ref="input" name="file_upload" id="chose-background" accept="image/*" >
        <button @click="setBackground()">Готово</button>
    </div>
</template>


<script setup>
import {ref} from 'vue';
import axios from 'axios';
import config from '../config';
import { useAppStore } from '../store';
import router from '../Router';

const input  = ref(null)
const opacity = ref(50)
const store = useAppStore();

async function setBackground(){

    let data = new FormData();

    data.append("user_id", store.user);
    data.append("password", store.password);
    data.append("file", input.value.files[0]);
    data.append("opacity", opacity.value);

    console.log(opacity.value)
    try {
        let res = await axios.post(config.url + "setBackground.php", data,   {
        Headers : {
            'content-type': 'multipart/form-data'
        }})
        router.replace("/")
    }
    catch(e){
        console.log(e)
    }

}


</script>


<style scoped lang="scss">

#settings{
    background: rgb(22, 22, 22);
    height: 100%;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 20px;

    input {
        width: 80%;
    }
    label, button {
        background-color: transparent;
        color: white;
        height: 50px;
        border: 2px solid yellow;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        width: 50%;
    }
}

</style>