<?php
// Simple WebSocket server for testing
$host = '0.0.0.0';
$port = 8091;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, $host, $port);
socket_listen($socket);

echo "Simple WS Server started on port $port\n";

$client = socket_accept($socket);
if ($client) {
    echo "Client connected!\n";
    $input = socket_read($client, 1024);
    echo "Received: $input\n";

    // Send WebSocket handshake
    $handshake = "HTTP/1.1 101 Switching Protocols\r\n"
        . "Upgrade: websocket\r\n"
        . "Connection: Upgrade\r\n"
        . "Sec-WebSocket-Accept: s3pPLMBiTxaQ9kYGzzhZRbK+xOo=\r\n"
        . "\r\n";
    socket_write($client, $handshake);
    echo "Sent handshake\n";

    socket_close($client);
    echo "Client disconnected\n";
}

socket_close($socket);
