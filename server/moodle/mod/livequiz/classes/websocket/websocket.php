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
     * @var array $quizrooms
     */
    protected $quizrooms;

    /**
     * Constructor for the websocket class
     */
    public function __construct() {
        $this->clients = new \SplObjectStorage();
        $this->quizrooms = [];

        // This is testing and needs to be removed asap.
        $this->quizrooms[] = "abcdef";

        echo "server running!";
        return $this;
    }

    /**
     * creates a random string for the room id
     *
     * @return string
     */
    private function rand_room(): string {
        $alphabet = str_split("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
        $characterslength = count($alphabet);
        $codelength = 6;

        $randomstring = "";

        for ($i = 0; $i < $codelength; $i++) {
            $index = random_int(0, $characterslength - 1);
            $randomstring .= $alphabet[$index];
        }

        return $randomstring;
    }

    /**
     * When a client connects, it is stored in the clients SplObjectStorage data type.
     *
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onopen(ConnectionInterface $conn) {
        $queryparams = [];
        $params = $conn->httpRequest->getUri()->getQuery();
        parse_str($params, $queryparams);

        $requesttype = $queryparams['requesttype'];
        $userid = $queryparams['userid'] ?? null;

        if ($userid == null) {
            echo "userid was null!";
            return;
        }

        switch ($requesttype) {
            case 'connect':
                $room = $queryparams['room'] ?? null;

                if ($room == null) {
                    echo "Roomcode was null!";
                    return;
                }

                $this->handle_quiz_connect($conn, (int)$userid, $room);
                break;
            case 'openRoom':

                break;
            case 'startQuiz':
                $roomcode = $this->rand_room();
                $this->create_room($roomcode, $userid, $conn);
                $this->handle_start_quiz($roomcode);
                break;
            default:
                print("Invalid request type");
        }

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

        $this->clients->detach($conn);
        $conn->close();
    }

    /**
     * Handles connect requests
     *
     * @param ConnectionInterface $conn
     * @param int $studentid
     * @param string $roomcode
     * @return void
     */
    private function handle_quiz_connect(ConnectionInterface $conn, int $studentid, string $roomcode) {
        if ($this->room_exists($roomcode) == false) {
            echo "Room does not exist";
        }

        $clientinfo = [
            'studentid' => $studentid,
            'roomid' => $roomcode,
        ];

        $this->clients->attach($conn, $clientinfo);

        $conn->send("You have joined room: {$roomcode}");
    }

    /**
     * Returns true if roomid already exists in quizrooms
     *
     * @param int $roomid
     * @return bool
     */
    private function room_exists(string $roomid): bool {
        return in_array($roomid, $this->quizrooms);
    }


    /**
     * Sends a messsage to all clients that is connected to a specific room on quiz start
     *
     * @param string $roomid
     * @return void
     */
    private function handle_start_quiz(string $roomid) {
        if ($this->room_exists($roomid) == false) {
            echo "Room does not exists.";
            return;
        }

        foreach ($this->clients as $client) {
            $clientdata = $this->clients[$client];
            if ($clientdata['roomid'] !== $roomid) {
                $client->send("Quiz started.");
            }
        }
    }

    /**
     * Checks if room exists and then creates and saves it in the quizrooms array
     *
     * @param string $roomid
     * @param string $teacherid
     * @param ConnectionInterface $conn
     * @return array
     */
    private function create_room(string $roomid, string $teacherid, ConnectionInterface $from): array {
        if ($teacherid == null) {
            echo "Teacher id does not exists.";
            return [];
        }

        $quizinfo = [
            'roomid' => $roomid,
            'teacherid' => $teacherid,
        ];

        $this->quizrooms[] = $roomid;
        echo "Room {$roomid} generated.";


        $this->clients->attach($from, $quizinfo);
        $from->send($roomid);

        return $quizinfo;
    }

    /**
     * When teacher presses next question, clients in a specific room recieves message
     *
     * @param string $roomid
     * @return void
     */
    private function next_question($roomid) {
        if (!room_exists($roomid)) {
            echo "Room does not exists.";
        }

        foreach ($this->clients as $client) {
            $clientdata = $this->clients[$client];
            if ($clientdata['roomid'] !== $roomid) {
                $client->send("Next question started.");
            }
        }
    }
}
