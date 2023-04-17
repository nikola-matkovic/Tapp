<template>
    <div class="message" :class="userId == message.user_id ? 'right' : 'left'">
        <p v-if="message.text !== 'null'"> {{ message.text }} </p>
        <audio v-if="message.audio" controls :src='`${config.url}upload/${message.audio}`'></audio>
    </div>
</template>

<script setup>
import config from '../config';

defineProps({
    message: Object,
    userId: [Number, String],
})

</script>


<style scoped>

.message{
    margin-left: 20px;
    padding: 10px;
    border-radius: 10px;
    white-space: pre-wrap;
    color: rgb(17, 27, 33);
    line-height: 20px;
	width: fit-content;
    max-width: 80%; 
    box-shadow:2px 2px 5px 0 rgba(0, 0, 0, .3)
}
.left {
    background: hsl(280, 100%, 50%);
    color: white;
}
.right {
    background: hsl(58, 100%, 50%);
    color: black;
    align-self: flex-end;
}

audio *{
    background-color: black;
}

</style>