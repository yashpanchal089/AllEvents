<?php
$filename = $_FILES['file']['tmp_name'];
$file = fopen($filename, "r+");

// $continue = false;//
// $header_validation = ['Name','Email','Number','Gender','Technologies','Country','State','City'];
$count = 0;
while ($row_import_data_array = fgetcsv($file)) //getting data into $data
{
    $data[] = $row_import_data_array;
    // if ($count == 0)
    // {
    //     $header = $row_import_data_array;
    //     $count++;
    //     continue;
    // }

    // $event_id     = $row_import_data_array[0];
    // $event_id     = mysqli_real_escape_string($conn, $event_id);
    // $event_name   = $row_import_data_array[1];
    // $event_name   = mysqli_real_escape_string($conn, $event_name);
    // $start_time   = $row_import_data_array[2];
    // $start_time   = mysqli_real_escape_string($conn, $start_time);
    // $end_time     = $row_import_data_array[3];
    // $end_time     = mysqli_real_escape_string($conn, $end_time);
    // $time_zone    = $row_import_data_array[4];
    // $time_zone    = mysqli_real_escape_string($conn, $time_zone);
    // $city         = $row_import_data_array[5];
    // $city         = mysqli_real_escape_string($conn, $city);
    // $state        = $row_import_data_array[6];
    // $state        = mysqli_real_escape_string($conn, $state);
    // $country      = $row_import_data_array[7];
    // $country      = mysqli_real_escape_string($conn, $country);
    // $description  = $row_import_data_array[8];
    // $description  = mysqli_real_escape_string($conn, $description);
    // $banner_url   = $row_import_data_array[9];
    // $banner_url   = mysqli_real_escape_string($conn, $banner_url);
    // $score        = $row_import_data_array[10];
    // $categories   = $row_import_data_array[11];
    // $categories   = mysqli_real_escape_string($conn, $categories);

    // $insert_data_query = "INSERT INTO `events`(`event_id`,`event_name`, `start_time`, `end_time`, `timezone`, `city`, `state`, `country`, `banner_url`, `score`, `category`) VALUES ('$event_id','$event_name','$start_time','$end_time','$time_zone','$city','$state','$country','$banner_url','$score','$categories')";
    // $result = mysqli_query($conn, $insert_data_query);
}
print_r($data);
