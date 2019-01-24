<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// Include ratchet libs
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

use App\Sockets\Chat;
use Ratchet\App;

class SocketCommand extends Command
{

    private $httpServer;

    protected $em;

    public function __construct(HttpServer $httpServer, EntityManagerInterface $em)
    {
        parent::__construct();

        $this->httpServer = $httpServer;
        $this->em = $em;
    }


    protected function configure()
    {
        $this->setName('sockets:start-chat')
            ->setHelp("Starts the chat socket")
            ->setDescription('Starts the chat socket')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Chat socket',
            '============',
            'Starting chat',
            '============',
            'Chat started',
        ]);


        $server = IoServer::factory($this->httpServer,9001);

        $server->run();

    }
}
