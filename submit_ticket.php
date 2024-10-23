<?php
session_start();

// Check if the user is logged in by verifying if the session variable is set
if (!isset($_SESSION['username'])) {
    // User is not logged in
    echo "<script>
            alert('You are not logged in. Please log in to continue.');
            window.location.href = 'login.php';
          </script>";
    exit();
}

// Check if the user role is 'user'
if ($_SESSION['role'] !== 'user') {
    // User is logged in but not a regular user
    echo "<script>
            alert('Access denied: You do not have permission to access this page.');
            window.location.href = 'logout.php'; // Change to the appropriate dashboard
          </script>";
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "support_system";

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form fields are set
if (isset($_POST['subject']) && isset($_POST['description'])) {
    // Get the form data and sanitize inputs
    $subject = $conn->real_escape_string($_POST['subject']);
    $description = $conn->real_escape_string($_POST['description']);
    
    // Get the username from the session
    $username_session = $_SESSION['username'];

    // Insert the ticket into the database using the session username
    $sql = "INSERT INTO tickets (subject, description, status, username) 
            VALUES ('$subject', '$description', 'Open', '$username_session')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Ticket successfully submitted!');
                window.location.href = 'user_dashboard.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Please fill all required fields.";
}


$conn->close();
?>
