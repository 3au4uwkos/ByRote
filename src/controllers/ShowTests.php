<?php
    require_once(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "DBManager.php");
    require_once(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "LinkParser.php");

    $current = 0;
    $testpage = LinkParser::getLink("test");

    function showTests()
    {
      global $current, $testpage;
      $tests = DBManager::showTests($current, $_SESSION["userid"]);
      foreach($tests as $test)
      {
        echo "  <div class='col'>" . PHP_EOL;
        echo "    <div class='card text-dark mb-3' style='max-width: 18rem;'>" . PHP_EOL;
        echo "    <a href='$testpage?id=" . $test[2] . "' style='text-decoration: none;' >" . PHP_EOL;
        echo "      <div class='card-body'>" .PHP_EOL;
        echo "        <h5 class='card-title'>" . $test[0] . "</h5>". PHP_EOL;
        echo "        <p class='card-text'>" . $test[1] . "</p>" . PHP_EOL;
        echo "      </div>" . PHP_EOL;
        echo "    </a>" . PHP_EOL;
        echo "    </div>" . PHP_EOL;
        echo "  </div>" . PHP_EOL;
      }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true);
    $current = $data['current'];

    showTests();
}
?>