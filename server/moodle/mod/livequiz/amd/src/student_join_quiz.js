/* eslint-disable no-console */
// Define and export the init function
export const init = (url, studentid) => {
    console.log("Student Script is loaded and attempting to attach event listener.");

    const roomConnectionBtn = document.getElementById("room_connection_button");
    if (!roomConnectionBtn) {
        console.error("Button with id 'room_connection_button' not found!");
        return;
    }

    const roomCodeInput = document.getElementById("roomCode");
    if (!roomCodeInput) {
        console.error("Field with id 'roomCodeInput' not found!");
        return;
    }

    if (roomCodeInput.value === null || roomCodeInput.trim().value == "") {
        console.error("No room code found.");
        return;
    }

    // Sends message to socket when startQuiz button is pressed
    roomConnectionBtn.addEventListener("click", async () => {
        try {
            console.log("sending message"); // eslint-disable-line no-console
            const socket = await connect_to_socket(`${url}?requesttype=connect&userid=${studentid}&room=${roomCodeInput.value}`);
            socket.send("Testing some stuff for students" + ' ' + `${studentid}`);
        } catch (e) {
            console.error(`Student failed to join room, ${e}`);
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