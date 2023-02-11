<script setup>

import Message from './components/Message.vue';
import profilePhoto from './assets/profile.jpg';
import phone from './assets/phone.svg';
import video from './assets/video.svg';
import { onMounted, ref } from 'vue';
import axios from 'axios';

const messages = ref({});
const userId = ref("1");

onMounted(async () => {

	try {
		let res = await axios.get('http://localhost:3000/messages');
		messages.value = res.data;
	}

	catch (err) {
		console.log(err);
	}
});

</script>

<template>
	<div class="cont">
		<header>

			<div class="left">
				<img :src="profilePhoto" alt="">
			</div>

			<div class="center">
				<h3>Nikola Matković</h3>
			</div>

			<div class="right">
				<img :src="phone" alt="">
				<img :src="video" alt="">
				<div class="dots">
					<div class="dot"></div>
					<div class="dot"></div>
					<div class="dot"></div>
				</div>
			</div>

		</header>
		<main>
			<Message :userId="userId" v-for="message in messages" :key="message.id" :message="message" />
		</main>
	</div>
</template>

<style lang="scss">

:root{
	--profile-image-size: 50px;
	--header-padding-size: 10px;
	--icons-size : 20px;
	--header-size : var(--profile-image-size) + var(--header-padding-size) * 2; 
}

#app{
	width: 100vw;
	height: 100vh;
	display: grid;
	place-items: center;
}

header{
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: var(--header-padding-size);
	background: hsl(261, 100%, 80%);
	color: white;
	font-size: 15px;
    vertical-align: baseline;
    white-space: pre-wrap;
    color: rgb(17, 27, 33);
    line-height: 20px;
    .left img{
		width: var(--profile-image-size);
		height: var(--profile-image-size);
		border-radius: 50%;
		object-fit: cover;
	}
	.center h3{
		font-size: 1.5rem;
		letter-spacing: 3px;
	}
	.right{
		display: flex;
		justify-content: space-between;
		align-items: center;
	
		img {
			width: var(--icons-size);
			height: var(--icons-size);
			margin-right: 10px;	
		}

	    .dots{
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			align-items: center;
			width: 20px;
			height: 20px;
		}
		.dot {
			width: 5px;
			height: 5px;
			border-radius: 50%;
			background-color: black;
		}
	}
}

.cont {
	width: 470px;
	height: 80%;
	border: 1px solid black;
	border-radius: 10px;
	overflow: hidden;
	display: grid;
	grid-template-rows: var(--header-size) 1fr;
	resize: both;
}

main {
	display: flex;
	flex-direction: column;
	height: auto;
	flex-shrink: 0;
	overflow-y: auto;
	gap: 10px;
	padding: 10px;
	background-color: rgb(22, 22, 22);
}

::-webkit-scrollbar {
	width: 5px;
	background-color: rgb(131, 131, 184);
}

::-webkit-scrollbar-button {
	width: 0px;
	height: 0px;
}

::-webkit-scrollbar-thumb {
	background-color: rgb(208, 0, 0);
	width: 5px;
	height: 100px;
}

</style>
