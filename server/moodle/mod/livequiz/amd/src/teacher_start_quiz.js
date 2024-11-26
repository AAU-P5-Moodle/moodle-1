// Define and export the init function
export const init = (url) => {
    const startQuizBtn = document.getElementById("startQuiz");
    if (!startQuizBtn) {
        console.error("Button with id 'startQuiz' not found!"); // eslint-disable-line no-console
        return;
    }

    // Sends message to socket when startQuiz button is pressed
    startQuizBtn.addEventListener("click", () => {
        console.log("sending message"); // eslint-disable-line no-console
        socket.send("Testing some stuff");
    });
} 