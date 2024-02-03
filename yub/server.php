<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'websocket_demo';

// Create a new database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// WebSocket server configuration
$host = 'localhost';
$port = 8080;

// Create WebSocket server
$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($server, $host, $port);
socket_listen($server);

$clients = array();
$socketId = 0;

// Handle incoming WebSocket connections
while (true) {
    $socketNew = socket_accept($server);

    $header = socket_read($socketNew, 1024);
    performHandshaking($header, $socketNew, $host, $port);

    socket_getpeername($socketNew, $clientIP);
    $clients[$socketId]['socket'] = $socketNew;
    $clients[$socketId]['ip'] = $clientIP;
    $socketId++;

    $socketIndex = array_search($socketNew, $clients);

    // Read incoming WebSocket data
    while (socket_recv($clients[$socketIndex]['socket'], $buffer, 1024, 0) >= 1) {
        $receivedData = unmask($buffer);
        $data = json_decode($receivedData);

        // Store message in the database
        $username = $data->username;
        $message = $data->message;
        $sql = "INSERT INTO messages (username, message) VALUES ('$username', '$message')";
        $conn->query($sql);

        // Send the message to all connected clients
        foreach ($clients as $client) {
            $socket = $client['socket'];
            $response = mask(json_encode([
                'username' => $username,
                'message' => $message
            ]));
            socket_write($socket, $response, strlen($response));
        }

        break 2;
    }
}

// Close the WebSocket server
socket_close($server);

// Function to perform the WebSocket handshake
function performHandshaking($receivedHeader, $clientSocket, $host, $port) {
    $headers = array();
    $lines = preg_split("/\r\n/", $receivedHeader);
    foreach ($lines as $line) {
        $line = chop($line);
        if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secWebSocketKey = $headers['Sec-WebSocket-Key'];
    $secWebSocketAccept = base64_encode(pack('H*', sha1($secWebSocketKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
        "Upgrade: websocket\r\n" .
        "Connection: Upgrade\r\n" .
        "WebSocket-Origin: $host\r\n" .
        "WebSocket-Location: ws://$host:$port/server.php\r\n" .
        "Sec-WebSocket-Accept:$secWebSocketAccept\r\n\r\n";
    socket_write($clientSocket, $upgrade, strlen($upgrade));
}

// Function to unmask incoming WebSocket data
function unmask($text) {
    $length = ord($text[1]) & 127;
    if ($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    } elseif ($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    } else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }

    $text = '';
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i % 4];
    }
    return $text;
}

// Function to mask outgoing WebSocket data
function mask($text) {
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length > 125 && $length < 65536) {
        $header = pack('CCn', $b1, 126, $length);
    } elseif ($length >= 65536) {
        $header = pack('CCNN', $b1, 127, $length);
    }

    return $header . $text;
}
?>
