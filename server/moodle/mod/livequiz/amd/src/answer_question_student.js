/* eslint-disable no-console */
// Define and export the init function
export const init = (url, studentid) => {
    console.log("Initializing quiz interaction.");

    const nextQuestionBtn = document.getElementById("nextButton");
    if (!nextQuestionBtn) {
        console.error(`Next button not found!`);
        return;
    }

    const quizid = document.getElementsByName("quizid")[0].value;
    const cmid = document.getElementsByName("cmid")[0].value;
    const questionid = document.getElementsByName("questionid")[0].value;

    if (!quizid || !cmid || !questionid) {
        console.error(`Buttons with id 'quizid', 'cmid', 'questionid' not found!`);
        return;
    }

    nextQuestionBtn.addEventListener("mouseover", async () => {
        const socket = await connect_to_socket(`${url}?requesttype=nextquestion&userid=${studentid}`);
        console.log("Preparing to send data.");

        const answerElement = document.querySelectorAll(".answer input");
        if (!answerElement) {
            console.error("Answer id does not exists");
        }

        let idOfAnswers = Array.from(answerElement).filter((answer) => answer.checked).map((answer) => answer.value);

        const questiondata = {
            quizid,
            cmid,
            questionid,
            idOfAnswers,
        };

        try {
            if (!socket || socket.readyState !== WebSocket.OPEN) {
                console.log("Not ready to send data.");
            }
            console.log("sending message"); // eslint-disable-line no-console
            const message = JSON.stringify(questiondata);
            socket.send(message);
        } catch (e) {
            console.error(`Failed to send data of answer, ${e}`);
        }
    });
};


/**
 * Connects a websocket given url
 *
 * @param {string} url
 * @returns websocket reference
 */
function connect_to_socket(url) {
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