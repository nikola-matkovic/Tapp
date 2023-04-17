<template> 

<div class="cont">
    <RouterView> </RouterView>
</div>

</template>

<script setup>
import { RouterView } from 'vue-router';

</script>

<style>
.cont {
	width: 470px;
	height: 100%;
	border: 1px solid black;
	border-radius: 10px;
	overflow: hidden;
	display: grid;
	grid-template-rows: var(--header-size) 1fr 50px;
	resize: both;
	position: relative;
}

</style>
