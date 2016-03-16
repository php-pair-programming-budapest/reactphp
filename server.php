<?php
require 'vendor/autoload.php';
$client = file_get_contents('index.html');

$app = function (React\Http\Request $request,React\Http\Response $response) use ($client) {

    if ( $request->getMethod() === 'GET' ){
        $response->writeHead(200, array('Content-Type' => 'text/html'));
        $response->end($client);
    }
    else {
        $response->writeHead(200, array('Content-Type' => 'application/json'));

        $request->on('data', function($body) use ($response){
            parse_str($body, $body);
            $response->end(json_encode($body));
        });
    }

};

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket, $loop);

$http->on('request', $app);
echo "Server running at http://127.0.0.1:1337\n";

$socket->listen(1337);
$loop->run();


