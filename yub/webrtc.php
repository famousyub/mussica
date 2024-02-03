
<?php
// API endpoint URL
$url = 'https://api.example.com/data';

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json', // Set the Content-Type header if required
    'Authorization: Bearer your_access_token' // Add any required authentication headers
));

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
    // Handle the error gracefully
    // ...
}

// Close cURL session
curl_close($ch);

// Process the response
if ($response) {
    $data = json_decode($response, true); // Convert the response to an associative array
    // Process the data as needed
    // ...
} else {
    echo 'No response received';
}
?>


<html>
  <head>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
	
	<style>
	
	
	video {
  background-color: #ddd;
  border-radius: 7px;
  margin: 10px 0px 0px 10px;
  width: 320px;
  height: 240px;
}
button {
  margin: 5px 0px 0px 10px !important;
  width: 654px;
}
	</style>
  </head>
  <body onload="showMyFace()">
    <video id="yourVideo" autoplay muted></video>
    <video id="friendsVideo" autoplay></video>
    <br />
    <button onclick="showFriendsFace()" type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span> Call</button>
  
    <script>
	
	var config = {
  apiKey: "AIzaSyAZZl88CFWIGL8fVVp_63OfcimmyBuMkSE",
  authDomain: "webrtcvideochatcodepen.firebaseapp.com",
  databaseURL: "https://webrtcvideochatcodepen.firebaseio.com",
  projectId: "webrtcvideochatcodepen",
  storageBucket: "webrtcvideochatcodepen.appspot.com",
  messagingSenderId: "486754006627"
};
firebase.initializeApp(config);

var database = firebase.database().ref();
var yourVideo = document.getElementById("yourVideo");
var friendsVideo = document.getElementById("friendsVideo");
var yourId = Math.floor(Math.random()*1000000000);
var servers = {'iceServers': [{'urls': 'stun:stun.services.mozilla.com'}, {'urls': 'stun:stun.l.google.com:19302'}]};
var pc = new RTCPeerConnection(servers);
pc.onicecandidate = (event => event.candidate?sendMessage(yourId, JSON.stringify({'ice': event.candidate})):console.log("Sent All Ice") );
pc.onaddstream = (event => friendsVideo.srcObject = event.stream);

function sendMessage(senderId, data) {
  var msg = database.push({ sender: senderId, message: data });
  msg.remove();
}

function readMessage(data) {
  var msg = JSON.parse(data.val().message);
  var sender = data.val().sender;
  if (sender != yourId) {
    if (msg.ice != undefined)
      pc.addIceCandidate(new RTCIceCandidate(msg.ice));
    else if (msg.sdp.type == "offer")
      pc.setRemoteDescription(new RTCSessionDescription(msg.sdp))
        .then(() => pc.createAnswer())
        .then(answer => pc.setLocalDescription(answer))
        .then(() => sendMessage(yourId, JSON.stringify({'sdp': pc.localDescription})));
    else if (msg.sdp.type == "answer")
      pc.setRemoteDescription(new RTCSessionDescription(msg.sdp));
  }
};

database.on('child_added', readMessage);

function showMyFace() {
  navigator.mediaDevices.getUserMedia({audio:true, video:true})
    .then(stream => yourVideo.srcObject = stream)
    .then(stream => pc.addStream(stream));
}

function showFriendsFace() {
  pc.createOffer()
    .then(offer => pc.setLocalDescription(offer) )
    .then(() => sendMessage(yourId, JSON.stringify({'sdp': pc.localDescription})) );
}

	</script>
  
  </body>
</html>
