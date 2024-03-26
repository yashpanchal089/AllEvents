<?php
include "connection.php";
// print_r($_POST);
$event_id = $_POST['event_id'];
$user_id = $_POST['user_id'];
$insert_intersted_user_data_query = "INSERT INTO `intersted_users`(`user_id`, `event_id`) VALUES ('$event_id','$user_id')";
if(mysqli_query($conn,$insert_intersted_user_data_query))
{
    echo "data aaded to Db";
}
else
{
    echo "error! processing data";
}

?>