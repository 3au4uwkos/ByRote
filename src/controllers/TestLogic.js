document.addEventListener("DOMContentLoaded", function () {
    const keys = ["What is the capital of France?", "What is 2 + 2?", "What color is the sky?", "What is the chemical symbol for water?"];
    const values = ["Paris", "4", "Blue", "H2O"];

    let questions = {
        "What is the capital of France?": "Paris",
        "What is 2 + 2?": "4",
        "What color is the sky?": "Blue",
        "What is the chemical symbol for water?": "H2O"
    };

    let currentQuestionIndex = 0;
    let score = 0;

    const questionElement = document.getElementById("question");
    const answerButtons = [
        document.getElementById("answer1"),
        document.getElementById("answer2"),
        document.getElementById("answer3"),
        document.getElementById("answer4")
    ];
    const nextButton = document.getElementById("next-btn");

    // Initial event listener for answer buttons
    answerButtons.forEach(button => {
        button.addEventListener("click", handleAnswerClick);
    });

    // Display the first question
    displayQuestion();

    function displayQuestion() {
        const currentQuestion = keys[currentQuestionIndex];
        let correctAnswer = values[currentQuestionIndex];

        // Get 3 random incorrect answers from other questions
        let incorrectAnswers = getRandomIncorrectAnswers(correctAnswer);

        // Combine correct and incorrect answers, then shuffle
        let allAnswers = [correctAnswer, ...incorrectAnswers];
        shuffleArray(allAnswers);

        // Display the question
        questionElement.textContent = currentQuestion;

        // Display answers and enable the buttons
        for (let i = 0; i < answerButtons.length; i++) {
            answerButtons[i].textContent = allAnswers[i];
            answerButtons[i].classList.remove("correct", "incorrect");
            answerButtons[i].disabled = false;
        }

        // Hide "Go Further" button until an answer is selected
        nextButton.style.display = "none";
    }

    function handleAnswerClick(event) {
        const selectedAnswer = event.target.textContent;
        const currentQuestion = keys[currentQuestionIndex];
        const correctAnswer = questions[currentQuestion];

        if (selectedAnswer === correctAnswer) {
            event.target.classList.add("btn-success");
            score++;
        } else {
            event.target.classList.add("btn-danger");
            // Highlight the correct answer
            answerButtons.forEach(button => {
                if (button.textContent === correctAnswer) {
                    button.classList.add("btn-success");
                }
            });
        }

        // Disable buttons after selection
        answerButtons.forEach(button => button.disabled = true);

        // Show the "Go Further" button after selection
        nextButton.style.display = "block";
    }

    nextButton.addEventListener("click", () => {
        currentQuestionIndex++;
        if (currentQuestionIndex < keys.length) {
            answerButtons.forEach(button => {
        button.classList.remove("btn-success");
        button.classList.remove("btn-danger");
    });
            displayQuestion();
        } else {
            showResults();
        }
    });

    function showResults() {
        questionElement.textContent = `Test completed! Your score is ${score} out of ${keys.length}.`;
        answerButtons.forEach(button => button.style.display = "none");
        nextButton.style.display = "none";
    }

    function getRandomIncorrectAnswers(correctAnswer) {
        let incorrectAnswers = [];
        while (incorrectAnswers.length < 3) {
            let randomIndex = Math.floor(Math.random() * values.length);
            let randomAnswer = values[randomIndex];
            if (randomAnswer !== correctAnswer && !incorrectAnswers.includes(randomAnswer)) {
                incorrectAnswers.push(randomAnswer);
            }
        }
        return incorrectAnswers;
    }

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }
});
