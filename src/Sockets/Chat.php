<?php

namespace App\Sockets;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Doctrine\ORM\EntityManager;

class Chat implements MessageComponentInterface {

    protected $clients;

    protected $em;

    public function __construct(EntityManagerInterface $em) {
        $this->clients = new \SplObjectStorage;
        $this->em = $em;
    }

    public function persist_flush(string $msg) {


        $json = json_decode($msg, true);


        $message = new Message();
        $message->setSender($json['envoyeur']);
        $message->setReceiver($json['destinataire']);
        $message->setAnnonceId($json['annonce_id']);
        $message->setMessage($json['message']);

        try {
            $this->em->persist($message);
            $this->em->flush();
        } catch (ORMException $e) {
        }



    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $this->persist_flush($msg);

        foreach ($this->clients as $client) {
            if ($from !== $client) {

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