<?php
error_reporting(0);
include 'validate_function.php';
include 'session.php';
include "connection.php";
$status = "";
if(isset($_FILES['file']['name']))
{
  $filename = $_FILES['file']['tmp_name'];
  
  if($_FILES['file']['size'] > 0)//checking file available
  {
    if($_FILES['file']['size'] <= 10240)//checking file size
    {
      $file = fopen($filename, "r+");
      
      // $continue = false;//
      $header_validation = ['Name','Email','Number','Gender','Technologies','Country','State','City'];
      while($row_import_data_array = fgetcsv($file))//getting data into $data
      { 
        $data[] = $row_import_data_array;
      }
      $file_header = $data['0'];
      $start_import = true;
      foreach($file_header as $key => $fh)//header validation
      {
        if ($fh != $header_validation[$key])
        {
          $start_import = false;
          break;
        }
      }
      if($start_import)//heading validation access
      { 
        $folder = "uploads/imports/" . uniqid() . ".csv";
        $loop_output_file = fopen($folder,"w");
        $error = 0;
        foreach($data as $data_result_key => $data_result_value)//import & validation
        {
          if($data_result_key == 0)//adding success & remark in heading
          {
            $data_result_value[8] = "Success/Error";
            $data_result_value[9] = "Remark";
            fputcsv($loop_output_file,$data_result_value);
          }
          if($data_result_key > 0)//imports data to DB
          {
            $name         = $data_result_value[0];
            $email        = $data_result_value[1];
            $number       = $data_result_value[2];
            $gender       = $data_result_value[3];
            $tech         = $data_result_value[4];
            $country_name = $data_result_value[5];
            $state_name   = $data_result_value[6];
            $city_name    = $data_result_value[7];

            $loop_data_validation = fn_validate($name, $email, $number);

            if($gender == "Male" || $gender == "Female" || $gender == "Other")
            { 
              if($gender == "Male")//changing gender data according to database
              {
                $gender = "M";
              }
              if($gender == "Female")
              {
                $gender = "F";
              }
            }
            else
            {
              $loop_data_validation['gender'] = "Error in gender data";
            }

            //getting country id from country name
            $get_coutry_id_query          = "select `Countryid` from `country` where `ListOfCountry` = '$country_name'";
            $result_get_country_id_query  = mysqli_query($conn, $get_coutry_id_query);
            $row_get_country_id_query     = mysqli_fetch_assoc($result_get_country_id_query);
            $country_id   = $row_get_country_id_query['Countryid'];
            //getting state id from state name
            $get_state_id_query        = "select `stid`, `cnid` from `states` where `states` = '$state_name'";
            $result_get_state_id_query = mysqli_query($conn, $get_state_id_query);
            $row_get_state_id_query    = mysqli_fetch_assoc($result_get_state_id_query);
            $state_id = $row_get_state_id_query['stid'];
            $countryid_state_validation = $row_get_state_id_query['cnid'];
            //getting city id from city name
            $get_city_id_query        = "SELECT `ctid`, `stid` FROM `city` WHERE `city` = '$city_name'";
            $result_get_city_id_query = mysqli_query($conn, $get_city_id_query);
            $row_get_city_id_query    = mysqli_fetch_assoc($result_get_city_id_query);
            $city_id = $row_get_city_id_query['ctid'];
            $stateid_city_validation  = $row_get_city_id_query['stid'];

            if($countryid_state_validation !== $country_id)
            {
              $loop_data_validation['state_err'] = "State data error";
            }
            if($stateid_city_validation !== $state_id)
            {
              $loop_data_validation['city_err'] = "City data error";
            }
           
            //insert query + data insert
            if(empty($loop_data_validation))
            {
              $data_result_value[8] = "success";
              $get_import_data_query = "insert into `imports`(Name,Email,Number,Gender,Technologies,Country,States,City,status,is_deleted) values ('$name','$email','$number','$gender','$tech','$country_id','$state_id','$city_id',1,0)";
              mysqli_query($conn, $get_import_data_query);//sending data to database
              fputcsv($loop_output_file, $data_result_value);//adding data to new file
            }
            if(!empty($loop_data_validation))
            {
              $data_result_value[8] = "Error";
              $validation_error_string = implode(",",$loop_data_validation);
              $data_result_value[9] = $validation_error_string;
              fputcsv($loop_output_file, $data_result_value);//adding error data to new file
              $error++;
            }
          }
        }//foreach loop end
          $status = "CSV file successully imported, errors reported: $error";
      }
      else
      {
        $status = "Please choose correct file";
      }
    }
    else
    {
      $status = "CSV file size greater than 10kb";
    }
  }
  else
  {
    $status = "File not found!";
  }
}
$status = json_encode($status);
echo $status;
exit;
?>