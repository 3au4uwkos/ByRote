<?php 
    require_once(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "LinkParser.php");
    require_once(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "DBManager.php");
    $css = LinkParser::getLink("css");
    $js = LinkParser::getLink("js");
    $main = LinkParser::getLink("main");
    $home = LinkParser::getLink("home");
    $testpage = LinkParser::getLink("test");
    $createTest = LinkParser::getLink("createTest");
    $logo = LinkParser::getLink("logo");
    $info = LinkParser::getLink("info");
    $favicon16 = LinkParser::getLink("favicon16");
    $favicon32 = LinkParser::getLink("favicon32");
    $faviconApple = LinkParser::getLink("faviconApple");
    $manifest = LinkParser::getLink("manifest");
    $script = LinkParser::getLink("addPair");
    $back = LinkParser::getLink("background");
    
    $test_id = $_GET['id'] ?? null;

    if (!$test_id) {
      die("Test ID not provided.");
    }

    $test = DBManager::getTest($test_id);
    if($test === FALSE){
      die("There is no test with such id");
    }

    $questions = array();
    $answers = array();
    $keys = array();

    $key = '';
    $value = '';

    for($i = 0; $i < count($test); $i++){
      if($i % 2 == 0){
        $key = $test[$i];
        array_push($keys, $key);
      }
      else{
        $value = $test[$i];
        $questions[$key] = $value;
        array_push($answers, $value);
      }
    }

    shuffle($keys);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="apple-touch-icon" sizes="180x180" href='<?php echo $faviconApple ?>'>
  <link rel="icon" type="image/png" sizes="32x32" href='<?php echo $favicon32 ?>'>
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicon16 ?>">
  
  <link rel="manifest" href="<?php echo $manifest?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ByRote</title>
  <link href="<?php echo $css ?>" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="<?php echo $js ?>" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <style>
        .question-container {
            text-align: center;
            margin-top: 50px;
        }

        .answer-btn {
            width: 100%;
            margin-bottom: 20px;
        }

        .next-btn {
            margin-top: 20px;
            display: none; /* Hides the button initially */
        }

        .correct {
            background-color: green;
            color: white;
        }

        .incorrect {
            background-color: red;
            color: white;
        }
        .container-bg {
          background: #e6a8d7;
        }
    </style>
</head>

<body background="<?php echo $back;?>">
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
    const keys = JSON.parse('<?php echo json_encode($keys);?>') ;
    const values = JSON.parse('<?php echo json_encode($answers);?>') ;

    let questions = JSON.parse('<?php echo json_encode($questions);?>') ;

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
        let correctAnswer = questions[currentQuestion];

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
</script>
<nav class="navbar navbar-light navbar-expand-lg"style="background-color: #feb4d8;">
  <div class="container mx-auto">
    <a class="navbar-brand" href="<?php echo $main ?>">
      <img src = '<?php echo $logo ?>' alt = 'Logo' width="80">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto my-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo $main ?>">Welcome</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $info ?>">About application</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tests
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo $home ?>">My tests</a></li>
            <li><a class="dropdown-item" href="<?php echo $createTest ?>">Create test</a></li>
            <li><hr class="dropdown-divider"></li>
          </ul>
        </li>
      </ul>
      <ul>
        <a type="button" class="btn btn-primary px-auto pe-auto" href="<?php echo $home?>"><?php echo $_SESSION['user']?></a>
      </ul>
    </div>
  </div>
</nav>
<div class="container-bg col-md-9 mx-auto">
  <div class="container col-md-9 text-center min-vh-100 my-5" id='1'>
    <div class="row justify-content-center question-container">
      <div class="col-12">
          <h3 id="question" class="mb-4">Question text will appear here</h3>
      </div>
      <div class="col-md-6">
          <button id="answer1" class="btn btn-primary answer-btn"></button>
      </div>
      <div class="col-md-6">
          <button id="answer2" class="btn btn-primary answer-btn"></button>
      </div>
      <div class="col-md-6">
          <button id="answer3" class="btn btn-primary answer-btn"></button>
      </div>
      <div class="col-md-6">
          <button id="answer4" class="btn btn-primary answer-btn"></button>
      </div>
      <div class="col-12 text-center">
          <button id="next-btn" class="btn btn-success next-btn">Go Further</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
