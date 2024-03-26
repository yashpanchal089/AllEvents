<?php
echo "Where we are ready to the stage where we are ready to get connected to a database<br>";

$servername  = "localhost";
$username = "root";
$password = "";
$dbname = "dbyash";


$conn = mysqli_connect($servername, $username, $password, $dbname);

$event_name = "holi event";

$dateString = "2024-03-21 15:30:00"; // Format: "YYYY-MM-DD HH:MM:SS"
$timestamp = strtotime($dateString); // Convert the date string to a Unix timestamp
$start_time = date('d-m-Y H:i:s', $timestamp);// Format the timestamp into "date-month-year time" format

$EndDateString = "2024-03-21 15:30:00"; // Format: "YYYY-MM-DD HH:MM:SS"
$Endtimestamp = strtotime($EndDateString); // Convert the date string to a Unix timestamp
$end_time = date('d-m-Y H:i:s', $Endtimestamp);// Format the timestamp into "date-month-year time" format

$TimeZone = "Time zone in India (GMT+5:30)";

$City = "Mumbai";
$State = "Maharashtra";
$Country = "India";

$Description = "Hey there, Hello Universe, cretaing first project on php";

$BannerUrl = "123";

$Score = 56;

$category = "Festival";


$sql = "INSERT INTO `events`(`event_name`, `start_time`, `end_time`, `timezone`, `city`, `state`, `country`, `description`, `banner_url`, `score`, `category`) VALUES ('$event_name','$start_time','$end_time','$TimeZone','$City','$State','$Country','$Description','$BannerUrl','$Score','$category')";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Data Submitted succesfully";
}
else{
    echo "Error! while submitting the data";
}


echo "Connection was succesful";
?>