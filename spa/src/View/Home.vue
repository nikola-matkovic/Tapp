<script setup>

import Message from '../components/Message.vue';
import images from '../assets/index.js';
import { onMounted, ref, computed, watch } from 'vue';
import getMessages from '../functions/getMessages.js';
import Recorder from '../classes/Recorder.js';
import axios from 'axios';
import config  from '../config';

const { profilePhoto, phone, video, upload, camera, image, voice, smile, send, hearth } = images;

const messages = ref({});
const userId = ref("1");
const recorder = ref(null);
const prev = ref(null);
const imgPrev = ref(null);
const shouldShowPreview = ref(false);
const numberOfMessages = ref(null);
const main = ref(null);
const contentToSend = ref(null);
const userPassword = ref(null);


let debug = true;
if(!debug){
	userId.value = prompt("Unesite id:"); 
	if(userId.value == 1)
		userPassword.value = prompt("Draga moja ženo, koju puno volim, unesi šifru <3")
	else 
		userPassword.value = prompt("Unesi šifru")
}
else{
	userId.value = 2; 
	userPassword.value = "Nikola123";
}

restartContentToSend();

async function handleSend() {

	if (contentToSend.value.audio) {
		
		recorder.value.stop();
		
		let media = await recorder.value.getMedia();

		contentToSend.value.audio = media.blob;
	}

	await sendToServer()

	restartContentToSend();

	messages.value = await getMessages(userPassword.value);
	
	scrollToBottom();
}

async function sendToServer(){

	let content = {
		text: contentToSend.value.text,
		user_id: userId.value
	}

	let data = new FormData()

	for( let key in content){
		data.append(key, content[key])
	}

	await axios.post(`${config.url}addMessage.php`, data);
}

async function openRecorder(sources) {
	shouldShowPreview.value = true;
	if (sources.video) {
		contentToSend.value.video = "preview";
	}
	else if (sources.audio) {
		contentToSend.value.audio = "preview";
	}

	recorder.value = new Recorder(sources);

	await recorder.value.prev();
}


async function recordVoice(sources){
	recorder.value = new Recorder(sources);

	contentToSend.value.audio = "recording";

	await recorder.value.prev();
	await recorder.value.start();

}

async function handleRecordButtonClick(){
	if(isVideoRecording.value){
		recorder.value.stop()

		let media = await recorder.value.getMedia()

		prev.value.src = media.url;
		
		contentToSend.value.video = media.blob;

		contentToSend.value.audio = null;
	}
	else{
		recorder.value.start();

		contentToSend.value.video = "recording"
		contentToSend.value.audio = "recording"
	}
}

async function handleCapturePhotoClick(){

	if(isPhotoCaptured.value){
		recorder.value.prev();
		contentToSend.value.image = null;
		return
	}

	recorder.value.capturePhoto();

	let media = await recorder.value.getMedia()
	imgPrev.value.src = media.url;

	contentToSend.value.image = media.blob;
	contentToSend.value.audio = ""
}


function handleAddGalleryFiles(e){
	let files = Array.from(e.target.files)

	contentToSend.value.gallery = files.map(file => {

		let url = URL.createObjectURL(file);
		let type = file.type.split("/")[0]

		return {file, url, type};
	});
}

function handleAddFiles(e){
	contentToSend.value.files = e.target.files;
}

//computed properties

const isVideoRecording = computed(() => {
	return contentToSend.value.video === "recording";
});

const isAudioRecording = computed(() => {
	return contentToSend.value.audio === "recording";
});

const isVideoRecorded = computed(() => {
	return contentToSend.value.video instanceof Blob;
})

const isPhotoCaptured = computed ( () => {
	return contentToSend.value.image instanceof Blob;
})

const haveContentToSend = computed(() => {
	return Object.values(contentToSend.value).some(content => content !== null  && content?.length > 0);
});

const haveFilesForPrev = computed(() => { 
	return contentToSend.value.files.length > 0 || contentToSend.value.gallery.length > 0;
})

//watchers

watch(contentToSend, (newVal, oldVal) => {
	// console.log(newVal);
	},
	{deep: true}
);

//mounted

onMounted(async () => {

	messages.value = await getMessages(userPassword.value);
	numberOfMessages.value = messages.value.length;

	scrollToBottom()

	document.addEventListener("keydown" , (e) =>{
		if(e.key=== "Escape"){
			// restartContentToSend();
			shouldShowPreview.value = false;
		}
	})
	
	let interval = setInterval( async() => {
		messages.value = await getMessages(userPassword.value);
		if(messages.value.length > numberOfMessages.value)	{
			numberOfMessages.value = messages.value.length;
			scrollToBottom();
		}
	}, 1000)

});



//helpers

function restartContentToSend(){
	contentToSend.value = {
        audio: null,
        image: null,
        text: null,
        files: [],
        video: null,
		gallery: []
    };
}

async function handleKeyPress(e){
	if(e.key === "Enter"){
		await handleSend();
	}
}

function scrollToBottom(){
	let scrollHeight = main.value.scrollHeight; 
	let newScrollHeight = scrollHeight; 


	let interval = setInterval(() => {
		newScrollHeight = main.value.scrollHeight; 
		if(newScrollHeight !== scrollHeight){
			main.value.scrollTo(0, main.value.scrollHeight);
			clearInterval(interval);
		}
	}, 50);
}

</script>

<template>
	
	<div class="cont">
		<div class="video-prev" v-if="shouldShowPreview" >
			<video ref="prev" id="video-prev" :muted="!isVideoRecorded" :autoplay="!isVideoRecorded" :controls="isVideoRecorded"></video>
			<img :style="{display: isPhotoCaptured ? 'block' : 'none'  }" ref="imgPrev" alt="">
			<div class="settings">
				<button class="flash">Flash</button>
				<button class="mute">Mute</button>
				<button class="timer">Timer</button>
			</div>

			<div class="options">
				<button class="video-button" @click="handleRecordButtonClick">Video</button>
				<button class="photo-button" @click="handleCapturePhotoClick">Photo</button>
				<button class="change-button">Change</button>
			</div>
		</div>
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
				<div class="dots" @click="">
					<div class="dot"></div>
					<div class="dot"></div>
					<div class="dot"></div>
				</div>
			</div>

		</header>
		<main ref="main">
			<Message :userId="userId" v-for="message in messages" :key="message.id" :message="message" />
		</main>
		<footer>
			<div class="file-prev" v-if="haveFilesForPrev">
				<div v-for="file in contentToSend.gallery">
					<img v-if="file.type==='image'" :src="file.url" alt="">
					<video v-if="file.type==='video'" :src="file.url" alt=""> </video>
				</div>
			</div>

			<div class="asset-options">
				<div class="file" >
					<label for="file-picker">
						<img :src="upload" alt="">
					</label>
					<input type="file"  @change="handleAddFiles" id="file-picker" multiple>
				</div>
				<div class="camera" @click="openRecorder({audio: true, video: true})" >
					<img :src="camera" alt="">
				</div>
				<div class="image">
					<label for="gallery-picker">
						<img :src="image" alt="">
					</label>
					<input type="file" @change="handleAddGalleryFiles" id="gallery-picker" accept="image/*,video/*" multiple>
				</div>
				<div ref="voiceElement" class="voice" @click="recordVoice({audio: true, video: false})" >
					<img :src="voice" alt="">
				</div>
				<div class="text">
					<textarea @keypress="handleKeyPress" v-model="contentToSend.text" @change="handleChange"></textarea>
					<div class="smile">
						<img :src="smile" alt="">
					</div>
				</div>
				<div class="send">
					<div @keypress="handleKeyPress" @click="handleSend" v-if="haveContentToSend" class="send">
						<img :src="send" alt="">
					</div>
					<div v-else class="hearth-icon">
						<img :src="hearth" alt="">
					</div>
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
	--header-size : calc(var(--profile-image-size) + var(--header-padding-size) * 2); 
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
	height: 100%;
	border: 1px solid black;
	border-radius: 10px;
	overflow: hidden;
	display: grid;
	grid-template-rows: var(--header-size) 1fr 50px;
	resize: both;
	position: relative;
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
	overflow-x: hidden;
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
	position: relative;
}

footer .file-prev{
	position: absolute;
	display: grid;
	align-items: center;
	justify-content: space-evenly;
	grid-template-columns: repeat(auto-fill, minmax(80px, 1fr) ) ;
	grid-template-rows: auto auto;
	height: 200px;
	bottom: 50px;
	overflow: auto;
	gap: 10px;
	padding: 10px;
	left: 0;
	width: 100%;
	overflow: auto;
	background-color: rgb(10, 10, 10);
}


footer .asset-options {

	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 20px;
	padding: 0 10px;
	background-color: rgb(255, 255, 255);
	height: 50px;
	overflow: hidden;

	transition: all .4s;

	.image, 
	.camera, 
	.file, 
	.voice {
		overflow: hidden;
		width: 30px;
		transition: all .4s;
	}

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
		flex-grow: 1;
		transition: all .3s ease-in-out;
	}
	textarea {
		display: inline;
		width: 90%;
		height: 40px;
		border-radius: 20px;
		border: none;
		outline: none;
		resize: none;
		padding: 10px;
		padding-right: 50px;
		// background-color: rgb(30, 30, 30);
		border: 1px solid black;
		// color: white;
		transition: all .3s ease-in-out;
	}

	.text .smile {
		display: none;
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

.video-prev video{
	width: 100%;
	height: 100%;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 2;
	background-color: black
}

.video-prev img{
	z-index: 3;
	width: 100%;
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
}

.options, .settings{
	--height: 200px;
	position: absolute;
	bottom: 100px;
	height: var(--height);
	width: 100%;
	background-color: rgba(255, 255, 255, 0.1);
	display: flex;
	justify-content: space-between;
	align-items: center;
	z-index: 4;
	padding: 10px;
	.video-button, .photo-button, .change-button, .flash, .mute, .timer{
		width: min(calc(var(--height) - 30px), 20%);
        aspect-ratio: 1;
        background-color: black;
        border-radius: 50%;
		border: 3px solid white;
		outline: 3px solid white;
		outline-offset: 3px;
		color: white;
	}
}

.settings{
	bottom: unset;
	top: 0;
	--height: 100px;
}

input[type="file"]{
	display: none;
}

.file-prev div{
	width: 80px;
	height: 80px;
}

.file-prev img, .file-prev video{
	width: 80px;
	height: 80px;
	object-fit: cover;
	border-radius: 10px;
	border: 2px solid rgb(48, 48, 48);
}

.asset-options:has(textarea:focus){

	gap: 0;

	.file, 
	.image, 
	.camera, 
	.voice{
		width: 0;
	}

}


</style>
