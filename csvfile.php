<?php
// Create connection
$conn = mysqli_connect("localhost", "root", "", "dbyash");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT * FROM intersted_users"; // Replace 'your_table_name' with your actual table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Define CSV file path
    $csvFilePath = 'E:/data.csv'; // Change this to your desired file path
    
    // Open or create the CSV file
    $file = fopen($csvFilePath, 'w');

    // Write column headers to the CSV file
    $headers = array("Column1", "Column2", "Column3"); // Replace with your actual column names
    fputcsv($file, $headers);

    // Write data rows to the CSV file
    while ($row = $result->fetch_assoc()) {
        fputcsv($file, $row);
    }

    // Close the file
    fclose($file);

    echo "CSV file created successfully at: " . $csvFilePath;
} else {
    echo "No data found in the table.";
}

// Close MySQL connection
$conn->close();
?>
