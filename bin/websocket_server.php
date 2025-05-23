<?php
require __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config.php';

use Core\App;
use Core\Container;
use MODELS\Contact;
use MODELS\Chats;

$container = new Container();
$container->bind('Core\\Database', function () use ($config) {
    return new \Core\Database(
        [
            'host' => $config['database']['host'],
            'dbname' => $config['database']['dbname'],
            'port' => $config['database']['port'],
        ],
        $config['database']['user'],
        $config['database']['password']
    );
});
App::setContainer($container);

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use React\EventLoop\Factory as LoopFactory;
use React\Socket\Server as SocketServer;

class WebSocketServer implements MessageComponentInterface {
    public $clients;
    protected $chatsModel;
    
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->chatsModel = new Chats();
        echo "WebSocket ya estoy corriendo!\n";
    }
    
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }
    
    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true); // <-- Add this line
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        // Store chat messages in the database
        if (isset($data['type']) && $data['type'] === 'chat') {
            if (isset($data['data']) && isset($data['data']['emisor']) && isset($data['data']['receptor']) && isset($data['data']['texto'])) {
                try {
                    $this->chatsModel->saveMessage(
                        $data['data']['emisor'],
                        $data['data']['receptor'],
                        $data['data']['texto']
                    );
                    echo "Message saved to database\n";
                } catch (\Exception $e) {
                    echo "Error saving message to database: {$e->getMessage()}\n";
                }
            }
        }
        
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }
    
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }
    
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
    
    public function broadcastFromFile(string $filePath) {
        if (!file_exists($filePath)) return;
        
        $content = file_get_contents($filePath);
        $messages = json_decode($content, true);
        
        if (!is_array($messages) || empty($messages)) return;
        
        foreach ($messages as $entry) {
            if (!isset($entry['message'])) continue;
            $msg = $entry['message'];
            echo "Broadcasting message from file: $msg\n";
            foreach ($this->clients as $client) {
                $client->send($msg);
            }
        }
        
        // Clear the file after broadcasting
        file_put_contents($filePath, json_encode([]));
    }
}

// Create loop and server
$loop = LoopFactory::create();
$websocketApp = new WebSocketServer();

// Create a socket
$socket = new SocketServer('0.0.0.0:8080', $loop);

// Set up the Ratchet WebSocket server
$wsServer = new IoServer(
    new HttpServer(
        new WsServer($websocketApp)
    ),
    $socket
);

// Set up periodic timer to check the file every 1 second
$loop->addPeriodicTimer(1, function () use ($websocketApp) {
    $filePath = __DIR__ . '/../storage/websocket_notifications.json';
    $websocketApp->broadcastFromFile($filePath);
});

echo "Estoy corriendo en el puerto 8080\n";
$loop->run();