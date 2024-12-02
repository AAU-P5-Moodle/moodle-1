/* eslint-disable no-console */
// Define and export the init function
export const init = (url, studentid) => {
    console.log("Student Script is loaded and attempting to attach event listener.");

    const roomConnectionBtn = document.getElementById("room_connection_button");
    if (!roomConnectionBtn) {
        console.error("Button with id 'room_connection_button' not found!");
        return;
    }

    let roomCodeInput = document.getElementById("roomCode");
    if (!roomCodeInput) {
        console.error("Field with id 'roomCodeInput' not found!");
        return;
    }
    let roomCodeValue = "";

    let socket;
    // Sends message to socket when startQuiz button is pressed
    roomConnectionBtn.addEventListener("click", async () => {
        if (roomCodeValue === roomCodeInput.value) {
            console.error("Room code already entered.");
            return;
        }
        roomCodeValue = roomCodeInput.value;
        if (roomCodeValue === null || roomCodeValue.trim() === "") {
            console.error("No room code found.");
            return;
        }
        roomCodeInput.disabled = true;
        roomConnectionBtn.disabled = true;

        try {
            console.log("sending message"); // eslint-disable-line no-console
            socket = await connect_to_socket(`${url}?requesttype=connect&userid=${studentid}&room=${roomCodeValue}`);
            socket.send("Testing some stuff for students" + ' ' + `${studentid}`);
        } catch (e) {
            console.error(`Student failed to join room, ${e}`);
        }
    });

    const leaveRoomBtn = document.getElementById("leave_room_button");

    if (!leaveRoomBtn) {
        console.error("Button with id 'leave_room_button' not found!");
        return;
    }

    // Sends message to socket when startQuiz button is pressed
    leaveRoomBtn.addEventListener("click", async () => {
        const requesttype = "leaveroom";

        let leave_room_request = {
            roomCodeValue,
            requesttype,
            studentid,
        };
        try {
            console.log("sending message"); // eslint-disable-line no-console
            socket.send(JSON.stringify(leave_room_request));
            socket.onclose();
            roomCodeInput.disabled = false;
            roomConnectionBtn.disabled = false;
            roomCodeValue = "";
        } catch (e) {
            console.error(`Student failed to leave room, ${e}`);
        }
    });

};


/**
 * Connects a websocket given url
 *
 * @param {string} url
 * @returns websocket reference
 */
async function connect_to_socket(url) {
    let socket;
    socket = new WebSocket(url);
    let myPromise = new Promise(function (myResolve, myReject) {
        socket.onopen = () => {
            console.log("WebSocket connection established successfully!");
            myResolve(socket);
        };
        // Handle errors
        socket.onerror = (error) => {
            console.error("WebSocket encountered an error:", error);
            myReject();
        };
        console.log("WebSocket object created, awaiting connection.");
        // Handle incoming messages
        socket.onmessage = (event) => {
            console.log("WebSocket message received:", event.data);
        };
        // Handle connection close
        socket.onclose = () => {
            console.log("WebSocket connection closed.");
        };
    });
    return myPromise;
}