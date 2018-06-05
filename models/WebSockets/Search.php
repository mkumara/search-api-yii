<?php
namespace app\models\WebSockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Search implements MessageComponentInterface 
{
   protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        $querystring = $conn->httpRequest->getUri()->getQuery();
        echo "New connection! ({$conn->resourceId})\n";
        parse_str($querystring, $token);
        $jsonArray = json_decode($token['token'], true);
        if($jsonArray['token'] != env('API_TOKEN'))
        {
        	$conn->close();
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
    	$result = json_decode($msg, true);

		if (json_last_error() === JSON_ERROR_NONE) 
		{
		    if (isset($result['term']))
		    {
		    	$response = WebSocketResponse::generate($result);
		    	$returnMessage = json_encode(["status"=>"success", "message" => $response]);
		    	$from->send($returnMessage);
		    }
		    else
		    {
		    	$from->send(json_encode(["status" => "error", "message" => "invalid request"]));
		    }
		}   	
                  
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
