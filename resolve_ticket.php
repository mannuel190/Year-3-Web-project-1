<?php
// Database connection details
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "support_system"; 

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection to the database
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error); // Exit if connection fails
}

// Check if ticket ID is provided via POST request
if (isset($_POST['ticket_id'])) 
{
    $ticket_id = intval($_POST['ticket_id']); //convert ticket ID to an integer
    
    // Update ticket status to 'Resolved' and set the resolved_at timestamp to the current time
    $sql = "UPDATE tickets SET status='Resolved', resolved_at=NOW() WHERE ticket_id=$ticket_id";
    
    // Execute the SQL query and check for success
    if ($conn->query($sql) === TRUE) 
    {
        // If successful, show an alert and go back to the previous page
        echo "<script>
                alert('Ticket resolved successfully!');
                window.history.back();
              </script>";
    } 
    else 
    {
        echo "Error updating record: " . $conn->error; // Display error if the query fails
    }
} 
else 
{
    // If no ticket ID is provided, show an error message
    echo "<script>
            alert('No Ticket ID selected!');
            window.location.href = 'user_dashboard.php';
          </script>";
}

// Close the database connection
$conn->close();

?>
