<script setup>

import Message from './components/Message.vue';
import profilePhoto from './assets/profile.jpg';
import phone from './assets/phone.svg';
import video from './assets/video.svg';
import camera from './assets/camera.svg';
import image from './assets/image.svg';
import voice from './assets/voice.svg';
import smile from './assets/smile.svg';
import hearth from './assets/heart.svg';
import send from './assets/send.svg';
import file from './assets/file.svg';
import { onMounted, ref } from 'vue';
import axios from 'axios';

const messages = ref({});
const userId = ref("1");
const haveContentToSend = ref(false);

const contentToSend = ref({
	audio: null,
	image: null,
	text: null,
	file: null,
});

function handleChange() {
	console.log(contentToSend.value);
}


onMounted(async () => {

	try {
		let res = await axios.get('http://localhost:3000/messages');
		messages.value = res.data;
	}

	catch (err) {
		console.log(err);
	}
});

function startRecording() {
	
}

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
		<footer>
			<div class="file">
				<img :src="file" alt="">
			</div>
			<div class="camera">
				<img :src="camera" alt="">
			</div>
			<div class="image">
				<img :src="image" alt="">
			</div>
			<div class="voice" onclick="startRecording">
				<img :src="voice" alt="">
			</div>
			<div class="text">
				<textarea v-model="contentToSend.text" @change="handleChange"></textarea>
				<div class="smile">
					<img :src="smile" alt="">
				</div>
			</div>
			<div class="send">
				<div @click="handleSend" v-if="haveContentToSend" class="send">
					<img :src="send" alt="">
				</div>
				<div v-else class="hearth-icon">
					<img :src="hearth" alt="">
				</div>
			</div>
		</footer>
	</div>
</template>

<style lang="scss">

:root{
	--profile-image-size: 50px;
	--header-padding-size: 5px;
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
	padding : var(--header-padding-size) 30px;
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
		cursor: pointer;
	}

	.center h3{
		font-size: 20px;
		letter-spacing: 2px;
		color: rgb(24, 24, 24);
	}

	.right{
		display: flex;
		justify-content: space-between;
		align-items: center;
	
		img {
			width: var(--icons-size);
			height: var(--icons-size);
			margin-right: 10px;	
			cursor: pointer;
		}

	    .dots{
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			align-items: center;
			width: 20px;
			height: 20px;
			cursor: pointer;
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
	grid-template-rows: var(--header-size) 1fr 50px;
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

footer {
	display: flex;
	align-items: center;
	justify-content: space-evenly;
	gap: 20px;
	padding: 0 10px;
	background-color: rgb(234, 216, 216);
	height: 50px;

	img {
		width: 30px;
		height: 30px;
		cursor: pointer;
	}
	.text {
		position: relative;
		height: 40px;
		display: flex;
		justify-self: center;
		align-items: center;
	}
	textarea {
		width: 100%;
		height: 40px;
		border-radius: 20px;
		border: none;
		outline: none;
		resize: none;
		padding: 10px;
		padding-right: 50px;
	}

	.text .smile {
		position: absolute;
		right: 5px;
		bottom: 20px;
		transform: translateY(50%);
		height: 30px;
	}
}

textarea::-webkit-scrollbar{
	width: 0px;
	height: 0px;
}
textarea::-webkit-scrollbar-thumb{
	background: transparent;
	border: none;
}


</style>
