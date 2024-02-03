<?php 









?>


<!DOCTYPE html>
<html>
<head>
    <title>chatty</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="chat-box"></div>
    <input type="text" id="message-input" placeholder="Type your message..." />
    <button id="send-button">Send</button>

    <script>
        var webSocket = new WebSocket("ws://localhost:8080/server.php");

        webSocket.onmessage = function(event) {
            var message = JSON.parse(event.data);
            var chatBox = document.getElementById('chat-box');
            chatBox.innerHTML += '<p><strong>' + message.username + ':</strong> ' + message.message + '</p>';
        };

        document.getElementById('send-button').addEventListener('click', function() {
            var input = document.getElementById('message-input');
            var message = input.value;
            var username = 'User'; // Change this to dynamically assign a username

            var data = {
                username: username,
                message: message
            };

            webSocket.send(JSON.stringify(data));
            input.value = '';
        });
    </script>
</body>
</html>
