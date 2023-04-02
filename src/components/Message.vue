<template>
    <div class="message" :class="userId == message.user_id ? 'right' : 'left'">
        <p> {{ message.text }}</p>
    </div>
</template>

<script setup>

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
	width: 80%;
}
.left {
    background: hsl(261, 100%, 90%);
}
.right {
    background: hsl(190, 100%, 90%);
    align-self: flex-end;
}


</style>