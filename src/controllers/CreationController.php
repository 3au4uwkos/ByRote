<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$json = file_get_contents('php://input');

require_once(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "DBManager.php");

$data = json_decode($json, true);

if (!isset($_SESSION['userid'])){

    echo json_encode([
        'status' => 'erorr',
        'message' => 'Please Log In!'
    ]);

}
else if (isset($data['name'], $data['description'], $data['dependencies'])) {
    $name = $data['name'];
    $description = $data['description'];
    $dependencies = json_encode($data['dependencies']);

    $result = DBManager::createTest($name, $description, $dependencies, $_SESSION['userid']);

    if($result === TRUE){

        echo json_encode([
        'status' => 'success',
        'message' => 'Test created successfully!'
    ]);
    } else {

        echo json_encode([
        'status' => 'error',
        'message' => 'DB erorr.' . $result
    ]);
    }

    
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON data'
    ]);
}
?>
