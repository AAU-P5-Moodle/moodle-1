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

/**
 * Documentation for start_websocket.php
 *
 * This starts the websocket server.
 *
 * @package mod_livequiz
 * @copyright Computer science Aalborg university  {@link http:/aau.dk}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('websocket.php');

use mod_livequiz\classes\websocket\websocket;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new websocket()
        )
    ),
    8001
);

$server->run();