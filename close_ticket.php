<?php
// Startthe session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "support_system";

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

// Check if ticket ID is provided via POST
if (isset($_POST['ticket_id'])) 
{
    $ticket_id = intval($_POST['ticket_id']);
    
    // Update the ticket's status to 'Closed'
    $sql = "UPDATE tickets SET status='Closed' WHERE ticket_id=$ticket_id";
    
    // Execute query and check for success
    if ($conn->query($sql) === TRUE) 
    {
        // If successful, show an alert and go back to the previous page
        echo "<script>
                alert('Ticket closed successfully!');
                window.history.back();
              </script>";
    } 
    else 
    {
        // If an error occurs, display the error
        echo "Error updating record: " . $conn->error;
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
