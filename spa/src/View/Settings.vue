<template>
    <div id="settings">
        <label for="chose-background">
            Odaberi pozadinu 
        </label>
        <input type="file" ref="input" name="file_upload" id="chose-background" accept="image/*" >
        <button @click="setBackground()">Gotovo</button>
    </div>
</template>


<script setup>
import {ref} from 'vue';
import axios from 'axios';
import config from '../config';
import { useAppStore } from '../store';

const input  = ref(null)


const store = useAppStore();

async function setBackground(){

    let data = new FormData();
    
    console.log(input.value.files)

    data.append("user_id", store.user);
    data.append("password", store.password);
    data.append("file", input.value.files[0]);

    try {
        let res = await axios.post(config.url + "setBackground.php", data,   {
        Headers : {
            'content-type': 'multipart/form-data'
        }})
        console.log(res)
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
    gap: 20px;

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
    }
}

</style>