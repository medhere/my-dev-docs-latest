<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class Video implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {

        // get user id on load from token, update resourceid to token as user
        $querystring = $conn->httpRequest->getUri()->getQuery();
        parse_str($querystring, $query);

        // store arbitrary data as str or obj
        // $conn->data = '';
        // get it back in onMessage function as $from->data

        // set custom connection nid
        $conn->resourceId = $query['user'];

        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        
        $data=json_decode($msg,true);
        // $data['sendfrom'] = $from->resourceId;

        foreach ($this->clients as $client) {
            if ($from !== $client && $client->resourceId === $data['sendto']) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}