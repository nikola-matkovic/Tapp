<script setup>

import Message from './components/Message.vue';
import profilePhoto from './assets/profile.jpg';
import phone from './assets/phone.svg';
import video from './assets/video.svg';

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
			<Message side="left" message="" />
			<Message side="right" message="Hello World" />
			<Message side="left" message="Hello World" />
			<Message side="right" message="Hello World" />
			<Message side="left" message="Hello World" />

		</main>
	</div>
</template>

<style lang="scss">

:root{
	--profile-image-size : 65px;
}

#app{
	width: 100%;
	height: 100%;
	display: grid;
	place-items: center;
}

header{
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 20px;
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
			width: 30px;
			height: 30px;
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

}
</style>
