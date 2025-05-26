const face = document.getElementById("video");
const btn = document.getElementById("btn");
const user_pic = document.getElementById("user_pic");

Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri("./../models"),
  faceapi.nets.faceLandmark68Net.loadFromUri("./../models"),
  faceapi.nets.faceRecognitionNet.loadFromUri("./../models"),
  faceapi.nets.ssdMobilenetv1.loadFromUri("./../models"),
])
  .then(getVideo)
  .catch((error) => {
    console.error("Failed to load models:", error);
  });

function getVideo() {
  navigator.getUserMedia(
    { video: {} },
    (stream) => (video.srcObject = stream),
    (err) => console.error(err)
  );
}

face.addEventListener("play", () => {
  const canvas = faceapi.createCanvasFromMedia(face);
  face.parentElement.appendChild(canvas);

  const displaySize = { width: face.videoWidth, height: face.videoHeight };
  faceapi.matchDimensions(canvas, displaySize);

  setInterval(async () => {
    const fd = await faceapi
      .detectAllFaces(face, new faceapi.TinyFaceDetectorOptions())
      .withFaceLandmarks();
    const rd = faceapi.resizeResults(fd, displaySize);
    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
    // faceapi.draw.drawDetections(canvas, rd)
    faceapi.draw.drawFaceLandmarks(canvas, rd);
  }, 100);
});

btn.addEventListener("click", async () => {
  const toast = document.querySelector(".toast");
  const bt = bootstrap.Toast.getOrCreateInstance(toast);

  const toast2 = document.querySelector(".toast2");
  const bt2 = bootstrap.Toast.getOrCreateInstance(toast2);

  const toast3 = document.querySelector(".toast3");
  const bt3 = bootstrap.Toast.getOrCreateInstance(toast3);

  const spinner = document.querySelector(".spinner");
  spinner.style.display = "block";

  const ccanvas = document.getElementById("ccanvas");
  const context = ccanvas.getContext("2d");
  const img = document.getElementById("captured-image");

  ccanvas.width = video.videoWidth;
  ccanvas.height = video.videoHeight;

  context.drawImage(face, 0, 0, ccanvas.width, ccanvas.height);
  img.src = ccanvas.toDataURL("image/png");
  img.style.display = "block";

  const detections = await faceapi
    .detectAllFaces(ccanvas)
    .withFaceLandmarks()
    .withFaceDescriptors();
  // console.log(`Face: ${detections.length}`)

  if (detections.length > 0) {
    try {
      const knownFaceImage = await loadKnownFaceImage(user_pic.src);
      const knownFaceDescriptor = await computeFaceDescriptor(knownFaceImage);

      if (knownFaceDescriptor) {
        // Use a threshold that fits your use case
        const faceMatcher = new faceapi.FaceMatcher(knownFaceDescriptor, 0.6);

        // Match detected faces with the known face
        const results = detections.map((fd) =>
          faceMatcher.findBestMatch(fd.descriptor)
        );

        // Display recognition results with detailed output
        results.forEach((result, index) => {
          console.log(`Face: ${detections.length} : ${result.toString()}`);

          const num = result._distance;
          var res = num.toFixed(2);
          // res <= 0.50 ? console.log("MATCH") : console.log("WALA NAG MATCH");
          // res <= 0.5 ? bt.show() : bt2.show();

          if(res <= 0.5){
            document.getElementById('btn_proceed').classList.remove('disabled')
            bt.show()
          }else{
            document.getElementById('btn_proceed').classList.add('disabled')
            bt2.show()
          }

          // console.log(`Detected Face ${index}:`, result.toString());
          // console.log(`Distance ${index}:`, result.distance);
        });
      } else {
        console.log("Failed to compute face descriptor for known face.");
      }
    } catch (error) {
      console.log("Error:", error);
    } finally {
      // res <= 0.50 ? console.log("MATCH") : console.log("WALA NAG MATCH");

      spinner.style.display = "none";
      // res <= 0.50 ? bt.show() : bt2.show();
    }
  } else {
    document.getElementById('btn_proceed').classList.add('disabled')
    spinner.style.display = "none";
    bt3.show();
    console.log("No detections found.");
  }
});

// Utility function to load a known face image
async function loadKnownFaceImage(url) {
  const img = await faceapi.fetchImage(url);
  return img;
}

// Utility function to compute face descriptor from an image
async function computeFaceDescriptor(image) {
  const detections = await faceapi
    .detectSingleFace(image)
    .withFaceLandmarks()
    .withFaceDescriptor();
  if (detections) {
    return detections.descriptor;
  } else {
    console.error("No face detected in the known image.");
    return null;
  }
}
