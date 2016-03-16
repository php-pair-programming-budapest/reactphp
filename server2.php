<?php
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require 'vendor/autoload.php';
require 'Chat.php';

$server = IoServer::factory(
    new \Ratchet\Http\HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

$server->run();