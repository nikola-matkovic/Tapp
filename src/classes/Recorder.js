export default class Recorder {

    constructor(sources) {
        this.media = null;
        this.recorder = null;
        this.sources = sources;
    }

    async prev() {

        this.stream = await navigator.mediaDevices.getUserMedia(this.sources)

        if (this.sources.video) { 
            this.videoPrev = document.getElementById('video-prev');
            this.videoPrev.srcObject = this.stream;
        }
    }

    async start(){

        if(!this.stream) await this.prev();

        this.recorder = new MediaRecorder(this.stream);

        this.recorder.start();

        const mediaChunks = [];

        this.recorder.addEventListener("dataavailable", event => {
            mediaChunks.push(event.data);
        });

        this.recorder.addEventListener("stop", () => {

            const blob = new Blob(mediaChunks);
            const url = URL.createObjectURL(blob)

            this.media = { blob, url };

        });

    }

    async capturePhoto(){
        if (!this.stream) {
            await this.prev();
        }

        const canvas = document.createElement('canvas');
        canvas.width = this.videoPrev.videoWidth;
        canvas.height = this.videoPrev.videoHeight;


        const ctx = canvas.getContext('2d');
        ctx.drawImage(this.videoPrev, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(blob => {
            this.media = {
                blob,
                url: URL.createObjectURL(blob)
            };
        }, 'image/jpeg', 1);
        
        this.clear();
    }

    stop() {
        this.recorder.stop()
        this.clear();
    }

    clear(){
        this.videoPrev.srcObject = null;
        this.stream.getTracks().forEach(function(track) {
            track.stop();
        });
        this.stream = null;
    }

    async getMedia() {
        return new Promise(resolve => {
            const interval = setInterval(() => {
                if (this.media) {
                    clearInterval(interval);
                    resolve(this.media);
                }
            }
            , 50);
        }) 
    }
}
