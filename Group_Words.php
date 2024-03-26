<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbyash";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch event data from the database
$sql = "SELECT event_name, description FROM events";
$result = $conn->query($sql);

// Initialize array to store keyword trends
$trends = array();

// Process each event
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Extract keywords from event name and description
        $keywords = preg_split("/[\s,]+/", $row['event_name'] . ' ' . $row['description']);

        // Count occurrences of each keyword
        foreach ($keywords as $keyword) {
            // Convert keyword to lowercase for case-insensitive grouping
            $keyword = strtolower($keyword);
            // Skip common words or symbols (adjust this list as needed)
            if (in_array($keyword, array('and', 'the', 'in', 'for', 'with', 'of', '&', '-', '/', '(', ')'))) {
                continue;
            }
            // Increment count for the keyword and store event name
            if (!isset($trends[$keyword])) {
                $trends[$keyword] = array('count' => 1, 'events' => array($row['event_name']));
            } else {
                $trends[$keyword]['count']++;
                $trends[$keyword]['events'][] = $row['event_name'];
            }
        }
    }
}

// Sort the trends array by occurrence count
arsort($trends);

// Display the trends
echo "<h2>Upcoming Event Trends Based on Keywords:</h2>";
echo "<table border='1'>";
echo "<tr><th>Keyword</th><th>Total Events</th></tr>";
foreach ($trends as $keyword => $data) {
    echo "<tr>";
    echo "<td>$keyword</td>";
    echo "<td>{$data['count']}</td>";
    echo "</tr>";
}
echo "</table>";

// Close the database connection
$conn->close();
?>
