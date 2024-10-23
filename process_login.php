<?php
// Start session
session_start();

// Database connection details
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "support_system";

//connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $submitted_username = $_POST['username']; // Retrieve submitted username
    $submitted_password = $_POST['password']; // Retrieve submitted password

    //SQL query to find the user by username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $submitted_username); // Bind the username to the query
    $stmt->execute(); 
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows === 1) 
    {
        $user = $result->fetch_assoc(); // Fetch the user data

        //comparison of the submitted password with the stored password
        if ($submitted_password === $user['password']) 
        {
            // Correct password, redirect based on user role
            if ($user['role'] === 'user') 
            {
                $_SESSION['username'] = $user['username']; // Store the username in session
                $_SESSION['role'] = $user['role']; // Store the user role in session
                header("Location: user_dashboard.php"); // Redirect to user dashboard
            } 
            elseif ($user['role'] === 'tier 1 agent') 
            {
                $_SESSION['username'] = $user['username']; // Store the username in session
                $_SESSION['role'] = $user['role']; // Store the user role in session
                header("Location: agent_dashboard.php"); // Redirect to agent dashboard
            }
            elseif ($user['role'] === 'tier 2 agent') 
            {
                $_SESSION['username'] = $user['username']; // Store the username in session
                $_SESSION['role'] = $user['role']; // Store the user role in session
                header("Location: agent_dashboard_2.php"); // Redirect to tier 2 agent dashboard
            }
            exit(); // Terminate script execution
        } 
        else 
        {
            // Incorrect password
            header("Location: login.php?error=Incorrect password"); // Redirect back to login with error
        }
    } 
    else 
    {
        // User not found
        header("Location: login.php?error=User not found"); // Redirect back to login with error
    }
} 
else 
{
    // If the form wasn't submitted, redirect back to login
    header("Location: login.php");
}

// Close connection
$conn->close();
?>
