<?php
require_once 'configuration\connect.php';
$event = mysqli_fetch_all(mysqli_query($connect, 'SELECT * FROM `event`'));
$useful =  mysqli_fetch_all(mysqli_query($connect, 'SELECT * FROM `useful`'));


$method = $_SERVER['REQUEST_METHOD'];

switch ($_GET['for']) {
    case 'event':
        switch ($method) {
            case 'GET':
                    echo json_encode($event);
                    break;
            case 'POST':
                    $arr = json_decode(file_get_contents('php://input'));
                    mysqli_query($connect, "INSERT INTO `event` (`id`, `name`, `description`, `image`) VALUES (NULL, '$arr[0]', '$arr[1]', '$arr[2]')");
                    break;        
            case 'DELETE':
                    mysqli_query($connect, 'DELETE from event where id='.file_get_contents('php://input').';');
                    break;
            case 'PATCH':
                    $fix = json_decode(file_get_contents('php://input'));
                    mysqli_query($connect, "UPDATE `event` SET `name` = '$fix[1]', `description` = '$fix[2]', `image` = '$fix[3]' WHERE `event`.`id` = ".$fix[0]);
                    break;
        }
        break;
    
    case 'useful':
        switch ($method) {
            case 'GET':
                echo json_encode($useful);
                break;
            
            case 'POST':
                $arr = json_decode(file_get_contents('php://input'));
                if (!mysqli_query($connect, "INSERT INTO `useful` (`id`, `name`, `date`, `desc`, `time`,`number`) VALUES (NULL, '$arr[0]', '$arr[1]', '$arr[2]', '$arr[3]', '$arr[4]')")) {
                    echo 1;
                }
                break;
            case 'DELETE':
                $Did = file_get_contents('php://input');
                if (!mysqli_query($connect, 'DELETE from useful where id='.$Did.';')) {
                    echo 1;
                }
                break;
            case 'PATCH':
                $fix = json_decode(file_get_contents('php://input'));
                if (!mysqli_query($connect, "UPDATE `useful` SET `name` = '$fix[1]', `date` = '$fix[2]', `desc` = '$fix[3]', `time` = '$fix[4]', `number` = '$fix[5]' WHERE `useful`.`id` = ".$fix[0])) {
                    echo 1;
                }
                break;
        }
        break;
}
?>