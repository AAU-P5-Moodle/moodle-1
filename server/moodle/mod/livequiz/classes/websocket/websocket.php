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

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;

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
     * @var SplObjectStorage $clients
     */
    protected SplObjectStorage $clients;

    /**
     * @var array $quizrooms
     */
    protected array $quizrooms;

    /**
     * Constructor for the websocket class
     */
    public function __construct() {
        $this->clients = new SplObjectStorage();
        $this->quizrooms = [];
        return $this;
    }

    /**
     * creates a random string for the room id
     *
     * @return string
     */
    private function rand_room(): string {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = str_shuffle($characters);
        return substr($str, 0, 6);
    }

    /**
     * When a client connects, it is stored in the clients SplObjectStorage data type.
     *
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onopen(ConnectionInterface $conn) {
        $params = $conn->httpRequest->getUri()->getQuery();
        $queryparams = [];
        parse_str($params, $queryparams);

        $requesttype = $queryparams['requesttype'];

        $userid = $queryparams['userid'] ?? null;
        $room = $queryparams['room'] ?? null;

        switch ($requesttype) {
            case 'connect':
                if (!$this->validate_requested_parameters($queryparams, ['room', 'userid'])) {
                    return;
                }
                $this->handle_quiz_connect($conn, (int)$userid, $room);
                echo "New connection! ({$conn->resourceId})\n";
                break;
            case 'createroom':
                $roomcode = $this->rand_room();
                // Keep trying new codes if it already exists.
                while ($this->room_exists($roomcode)) {
                    $roomcode = $this->rand_room();
                }
                $this->create_room($roomcode, $userid, $conn);
                break;
            default:
                print("Invalid request type.\n");
        }
    }

    /**
     * When a client sends a message it is echoed and sent to all other connected clients
     *
     * @param ConnectionInterface $from
     * @param $msg
     * @return void
     */
    public function onmessage(ConnectionInterface $from, $msg) {
        $params = $from->httpRequest->getUri()->getQuery();
        $queryparams = [];
        parse_str($params, $queryparams);
        $requesttype = $queryparams['requesttype'];

        $requestobject = json_decode($msg, true);
        if (!isset($requesttype)) {
            $from->send("Missing request format.\n");
            return;
        }

        if (!$this->validate_requested_parameters($queryparams, ['room'])) {
            return;
        }

        switch ($requesttype) {
            case 'startquiz':
                $roomid = $queryparams['room'];
                $this->send_message_to_room($roomid, "Quiz started.\n");
                break;
            case 'nextquestion':
                $this->send_message_to_room('abcde', "next question.\n");
                $from->send($msg);
                break;
            case 'leaveroom':
                $this->leave_room($queryparams['room'], $from, $queryparams['userid']);
                break;
            default:
                print("Invalid request type.\n");
        }
        
        // Send to all clients except sender.
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $clientdata = $this->clients[$client];
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
        $count = $conn->countClient;
        echo "Connection {$conn->resourceId} has disconnected. $count connections left\n";
    }

    /**
     * If an error is received from a client the connection is closed
     *
     * @param ConnectionInterface $conn
     * @param Exception $e
     * @return void
     */
    public function onerror(ConnectionInterface $conn, Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $this->clients->detach($conn);
        $conn->close();
    }

    /**
     * Checks if room exists and then creates and saves it in the quizrooms array
     *
     * @param string $roomid
     * @param string $teacherid
     * @param ConnectionInterface $from
     * @return array
     */
    private function create_room(string $roomid, string $teacherid, ConnectionInterface $from): array {
        if ($teacherid == null) {
            echo "Teacher id does not exists.\n";
            return [];
        }

        $quizinfo = [
            'roomid' => $roomid,
            'teacherid' => $teacherid,
        ];

        $this->quizrooms[] = $roomid;
        echo "Room $roomid generated.\n";

        $this->clients->attach($from, $quizinfo);
        echo "This is the room code: $roomid\n";
        $from->send($roomid);

        return $quizinfo;
    }

    /**
     * Returns true if roomid already exists in quizrooms
     *
     * @param string $roomid
     * @return bool
     */
    private function room_exists(string $roomid): bool {
        return in_array($roomid, $this->quizrooms);
    }

    /**
     * Handles connect requests
     *
     * @param ConnectionInterface $conn
     * @param int $studentid
     * @param string $roomcode
     * @return void
     */
    private function handle_quiz_connect(ConnectionInterface $conn, int $studentid, string $roomcode): void {
        if (!$this->room_exists($roomcode)) {
            echo "Room does not exist.\n";
        }

        $clientinfo = [
            'studentid' => $studentid,
            'roomid' => $roomcode,
        ];

        $this->clients->attach($conn, $clientinfo);

        $conn->send("You have joined room: $roomcode.\n");
        $this->send_message_to_room($roomcode, "{$conn->resourceId} connected to room: $roomcode.\n");
    }

    /**
     * Handles leaving room requests
     *
     * @param string $roomid
     * @param ConnectionInterface $conn
     * @param string $userid
     * @return void
     */
    private function leave_room(string $roomid, ConnectionInterface $conn, string $userid): void {
        echo "Leaving room $roomid.\n";
        foreach ($this->clients as $client) {
            if ($client == $conn) {
                $this->clients->detach($conn);
                echo "Connection {$client->resourceId} has disconnected from room $roomid\n";
                return;
            }
        }
        echo "Connection {$conn->resourceId} has disconnected from room $roomid\n";
    }

    /**
     * Handles when sending message to users within a specific room
     *
     * @param string $roomid
     * @param string $msg
     * @return void
     */
    private function send_message_to_room(string $roomid, string $msg): void {
        if (!$this->room_exists($roomid)) {
            echo "Room does not exists.\n";
            return;
        }

        foreach ($this->clients as $client) {
            $clientdata = $this->clients[$client];
            if ($clientdata['roomid'] == $roomid) {
                $client->send($msg);
            }
        }
    }

    /**
     * Used to validate the existence of requested parameters
     *
     * @param array $currentparams
     * @param array $requestedparams
     * @return bool
     */
    private function validate_requested_parameters(array $currentparams, array $requestedparams): bool {
        foreach ($requestedparams as $param) {
            if (!array_key_exists($param, $currentparams)) {
                echo "Missing required parameter.\n";
                return false;
            }
        }
        return true;
    }
}
