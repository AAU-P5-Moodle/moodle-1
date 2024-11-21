// Define and export the init function
export const init = (url) => {
    console.log("Script is loaded and attempting to attach event listener."); // eslint-disable-line no-console

    const button = document.getElementById("openconnection");
    if (!button) {
        console.error("Button with id 'openconnection' not found!"); // eslint-disable-line no-console
        return;
    }

    let socket; // WebSocket reference

    // Attach event listener to the button
    button.addEventListener('click', () => {
        console.log("Button clicked, attempting to open WebSocket connection..."); // eslint-disable-line no-console

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
    });

    console.log("Event listener attached to button with id 'openconnection'."); // eslint-disable-line no-console
};
