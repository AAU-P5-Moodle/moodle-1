<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace mod_livequiz\classes\websocket;

require(dirname(__DIR__) . '/../../../vendor/autoload.php');

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * Class websocket.
 *
 * This class represents the functionality to set up the websocket.
 *
 * @package mod_livequiz
 * @copyright 2024 Software AAU
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class websocket implements MessageComponentInterface {
    /**
     * @var \SplObjectStorage $clients
     */
    protected $clients;

    /**
     * Constructor for the websocket class
     */
    public function __construct() {
        $this->clients = new \SplObjectStorage();

        echo "server running!";
        return $this;
    }

    /**
     * When a client connects, it is stored in the clients SplObjectStorage data type
     *
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onopen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    /**
     * When a client sends a message it is echoed and sent to all other connected clients
     *
     * @param ConnectionInterface $from
     * @param $msg
     * @return void
     */
    public function onmessage(ConnectionInterface $from, $msg) {
        $receivercount = count($this->clients) - 1;

        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $receivercount,
            $receivercount == 1 ? '' : 's'
        );

        // Send to all clients except sender.
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    /**
     * When a client closes the connection it is removed from the
     * clients SplObjectStorage data type
     *
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onclose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    /**
     * If an error is received from a client the connection is closed
     *
     * @param ConnectionInterface $conn
     * @param \Exception $e
     * @return void
     */
    public function onerror(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
