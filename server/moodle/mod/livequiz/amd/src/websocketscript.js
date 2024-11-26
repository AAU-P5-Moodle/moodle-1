// Define and export the init function
export const init = (url) => {
    console.log("Script is loaded and attempting to attach event listener."); // eslint-disable-line no-console

    // Connects to socket when script loads
    let socket = connect_to_socket(url);

    /* const startQuizBtn = document.getElementById("startQuiz");
    if (!startQuizBtn) {
        console.error("Button with id 'startQuiz' not found!"); // eslint-disable-line no-console
        return;
    }

    // Sends message to socket when startQuiz button is pressed
    startQuizBtn.addEventListener("click", () => {
        console.log("sending message"); // eslint-disable-line no-console
        socket.send("Testing some stuff");
    }); */
    
    // This html element can be used to display the room code received once,
    // the teacher opens room and the websocket has responded
    const roomcodespan = document.getElementById("roomCode");
    if (!roomcodespan) {
        console.error("Span with id 'roomCode' not found!"); // eslint-disable-line no-console
        return;
    }

    roomcodespan.innerHTML = "test";
};

/**
 * Connects a websocket given url
 *
 * @param {string} url
 * @returns websocket reference
 */
function connect_to_socket(url) {
    let socket; // WebSocket reference
    try {
        // Initialize WebSocket connection
        socket = new WebSocket(url);
        console.log("WebSocket object created, awaiting connection."); // eslint-disable-line no-console

        // Handle successful connection
        socket.onopen = () => {
            console.log("WebSocket connection established successfully!"); // eslint-disable-line no-console
        };

        // Handle incoming messages
        socket.onmessage = (event) => {
            console.log("WebSocket message received:", event.data); // eslint-disable-line no-console
        };

        // Handle errors
        socket.onerror = (error) => {
            console.error("WebSocket encountered an error:", error); // eslint-disable-line no-console
        };

        // Handle connection close
        socket.onclose = () => {
            console.log("WebSocket connection closed."); // eslint-disable-line no-console
        };

    } catch (error) {
        console.error("Error initializing WebSocket connection:", error); // eslint-disable-line no-console
    }

    return socket;
}