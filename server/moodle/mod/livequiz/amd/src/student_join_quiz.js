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
        console.log("sending message"); // eslint-disable-line no-console
        connect_to_socket(`${url}?requesttype=connect&userid=${studentid}&room=abcdef`).then((socket) => {
            socket.send("Testing some stuff for students" + ' ' + `${studentid}`);
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
    let socket; // WebSocket reference
    socket = new WebSocket(url);

    let myPromise = new Promise(function(myResolve, myReject) {
        socket.onopen = () => {
            console.log("WebSocket connection established successfully!"); // eslint-disable-line no-console
            myResolve(socket);
        };


        // Handle errors
        socket.onerror = (error) => {
            console.error("WebSocket encountered an error:", error); // eslint-disable-line no-console
            myReject();
        };
    });

    try {
        console.log("WebSocket object created, awaiting connection."); // eslint-disable-line no-console

        // Handle successful connection


        // Handle incoming messages
        socket.onmessage = (event) => {
            console.log("WebSocket message received:", event.data); // eslint-disable-line no-console
        };


        // Handle connection close
        socket.onclose = () => {
            console.log("WebSocket connection closed."); // eslint-disable-line no-console
        };

    } catch (error) {
        console.error("Error initializing WebSocket connection:", error); // eslint-disable-line no-console
    }

    return myPromise;
}