const face = document.getElementById('video');
const btn = document.getElementById('btn');

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('./../models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('./../models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('./../models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri('./../models')
]).then(getVideo).catch(error => {
    console.error('Failed to load models:', error);
});

function getVideo(){
    navigator.getUserMedia(
        {video: {}},
        stream => video.srcObject = stream,
        err => console.error(err)
    )
}

face.addEventListener('play', () => {
    const canvas = faceapi.createCanvasFromMedia(face)
    face.parentElement.appendChild(canvas)

    const displaySize = {width: face.videoWidth, height: face.videoHeight}
    faceapi.matchDimensions(canvas, displaySize)

    setInterval(async() => {
        const fd = await faceapi.detectAllFaces(face, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks()
        const rd = faceapi.resizeResults(fd, displaySize)
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
        // faceapi.draw.drawDetections(canvas, rd)
        faceapi.draw.drawFaceLandmarks(canvas, rd)
    }, 100)
})


btn.addEventListener('click', async () => {
    const ccanvas = document.getElementById('ccanvas');
    const context = ccanvas.getContext('2d');
    const img = document.getElementById('captured-image');


    ccanvas.width = video.videoWidth;
    ccanvas.height = video.videoHeight;

    context.drawImage(face, 0, 0, ccanvas.width, ccanvas.height);
    img.src = ccanvas.toDataURL('image/png');
    img.style.display = 'block';


    const fd = await faceapi.detectAllFaces(img).withFaceLandmarks()
    console.log(fd.length)
})


