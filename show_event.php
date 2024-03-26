<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Document</title>
    <style>
        .card-img {
            min-width: 100px;
            width: 100px;
            height: 100px;
            object-fit: cover;
            /* This property ensures the image covers the entire space while maintaining its aspect ratio */
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Add box-shadow to cards */
            transition: box-shadow 0.3s ease;
            /* Add transition for smoother effect */
        }

        .card-body {
            min-height: 150px;
        }

        .card:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
            /* Increase box-shadow on hover */
        }

        .data-card{
            gap: 10px;
        }
    </style>
</head>

<body>
<div class="container">
        <h1 class="mt-4">Top Events of 2022</h1>
        <hr>
        <?php
        include "connection.php";
        
        $start_date = '2022-01-01';
        $end_date = '2022-12-31';
        
        $current_date = $start_date;
        
        while (strtotime($current_date) <= strtotime($end_date)) {
            $top_events_query = "SELECT * FROM `events` WHERE DATE(`start_time`) = '$current_date' ORDER BY `score` DESC LIMIT 4";
            $result = mysqli_query($conn, $top_events_query);
            
            if (mysqli_num_rows($result) > 0) {
                echo '<h3 class="mt-4">' . date('l, F j, Y', strtotime($current_date)) . '</h3>';
                echo '<div class="row">';
                
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex data-card">
                                    <div>
                                        <img src="<?php echo $row['banner_url']; ?>" alt="Event Banner" class="img-fluid card-img">
                                    </div>
                                    <div>
                                        <h5 class="card-title"><?php echo $row['event_name']; ?></h5>
                                        <button type="button" class="btn btn-primary" onclick="handleInterest(<?php echo $row['event_id']; ?>)">I'm Interested</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
                
                echo '</div>';
            }
            
            $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
        }
        ?>
    </div>



    <script>
        function handleInterest(eventid) {
            // Your code to handle the button click goes here
            // alert("You clicked the 'I'm interested' button where event id = " + eventid);
            $.ajax({
                url: 'events-backend.php',
                method: 'POST',
                data: {
                    event_id: eventid,
                    user_id: "example_user"
                },
                success: function(response) {
                    if (response.includes("data aaded to Db")) {
                        alert("we will contact u soon");
                    } else {
                        alert("error");
                    }
                }
            });
        }
    </script>
</body>

</html>