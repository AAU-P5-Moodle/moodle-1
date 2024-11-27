/* eslint-disable no-console */
// Define and export the init function
export const init = (url, studentid) => {
    console.log("Student Script is loaded and attempting to attach event listener.");
    const startQuizBtn = document.getElementById("room_connection_button");
    if (!startQuizBtn) {
        console.error("Button with id 'startQuiz' not found!");
        return;
    }
    // Sends message to socket when startQuiz button is pressed
    startQuizBtn.addEventListener("click", () => {
        console.log("sending message");
        connect_to_socket(url).then((socket) => {
            socket.send(`"Testing some stuff for students" ${studentid}`);
        });
    });
};


/**
 * Connects a websocket given url
 *
 * @param {string} url
 * @returns websocket reference
 */
async function connect_to_socket(url) {
    console.log(url);
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