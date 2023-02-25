export default class Recorder {

    constructor(sources) {
        this.media = null;
        this.recorder = null;
        this.sources = sources;
    }

    async start() {
        
        const stream = await navigator.mediaDevices.getUserMedia(this.sources)

        this.recorder = new MediaRecorder(stream);

        this.recorder.start();

        const mediaChunks = [];

        this.recorder.addEventListener("dataavailable", event => {
            mediaChunks.push(event.data);
        });
    
        this.recorder.addEventListener("stop", () => {

            const blob = new Blob(mediaChunks);
            const Url = URL.createObjectURL(blob);
            let mediaElement = null;

            if (this.sources.video) {
                mediaElement = document.createElement('video');
                mediaElement.src = Url;
                mediaElement.controls = true;
                mediaElement.autoplay = true;
            } else {
                mediaElement = new Audio(Url);
            }

            this.media = { blob, Url, mediaElement };
        
        });
    }

    stop() {
        this.recorder.stop();
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
