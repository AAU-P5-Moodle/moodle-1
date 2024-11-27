/* eslint-disable no-console */
// Define and export the init function
export const init = (url, teacherid) => {
    console.log("Teacher Script is loaded and attempting to attach event listener.");

    const startQuizBtn = document.getElementById("room_connection_button");
    if (!startQuizBtn) {
        console.error("Button with id 'startQuiz' not found!");
        return;
    }
    // Sends message to socket when startQuiz button is pressed
    startQuizBtn.addEventListener("click", () => {
        console.log("sending message"); // eslint-disable-line no-console
        connect_to_socket(`${url}?requesttype=createroom&userid=${teacherid}`).then((socket) => {
            socket.send(`"Testing some stuff for teachers" ${teacherid}`);
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
        // Handle successful connection
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
        // Handle incoming messages
        socket.onmessage = (event) => {
            console.log("WebSocket message received:", event.data); // eslint-disable-line no-console
            const roomCodeElem = document.getElementById("roomCode");
            if (!roomCodeElem) {
                console.error("Button with id 'roomCode' not found!");
                return;
            }

            roomCodeElem.innerHTML = event.data;
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