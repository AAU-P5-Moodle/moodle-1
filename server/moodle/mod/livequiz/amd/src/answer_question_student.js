/* eslint-disable no-console */
// Define and export the init function
export const init = (url, studentid) => {
    console.log("Script is loaded and attempting to attach event listener.");

    const nextQuestionBtn = document.getElementById("nextButton");
    if (!nextQuestionBtn) {
        console.error(`Button with id ${nextQuestionBtn.value} not found!`);
        return;
    }
    let quizid = document.getElementsByName("quizid")[0].value;
    let cmid = document.getElementsByName("cmid")[0].value;
    let questionid = document.getElementsByName("questionid")[0].value;

    if (!quizid || !cmid || !questionid) {
        console.error(`Button with id ${quizid} not found!`);
        return;
    } else {
        console.log(quizid.value);
        console.log(cmid.value);
        console.log(questionid.value);
    }
    let answerId = [];

    // document.getElementsByName('answer').forEach((answer) => {
        let answer = document.getElementById("answerid");
        console.log(answer);
        // if (answer.checked) {
        //     console.log(answer.value);
        //     answerId.push(answer.value);
        // }
    // });

    // Sends message to socket when startQuiz button is pressed
    nextQuestionBtn.addEventListener("mouseover", () => {

        const questiondata = {
            quizid: quizid,
            cmid: cmid,
            questionid: questionid,
            answers: answerId,
        };
        console.log("sending message"); // eslint-disable-line no-console
        connect_to_socket(`${url}?requesttype=nextquestion&userid=${studentid}`).then((socket) => {
            const message = JSON.stringify(questiondata);
            console.log("Sending message:", message);
            socket.send(message);
            socket.send(`"Testing some stuff for teachers and students" ${studentid}`);
        });
    });
};


/**
 * Connects a websocket given url
 *
 * @param {string} url
 * @returns websocket reference
 */
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