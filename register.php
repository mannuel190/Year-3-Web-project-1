<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "support_system";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

// If the form is submitted via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Retrieve and sanitize form input
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; // Get the selected role from the dropdown

    // Check if the password and confirm-password match
    if ($password !== $confirm_password)
    {
        // If passwords don't match redirect back to registration form
        echo "<script>alert('Passwords do not match!'); 
        window.location.href = 'register.php';
        </script>";
        session_destroy();
    }
    else
    {
        // Prepare a SQL statement to check if the username is already taken
        $sql = "SELECT username FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result(); // Store the result

        // If the username already exists in the database
        if ($stmt->num_rows > 0)
        {
            // Alert the user that the username is already taken and redirect back to the form
            echo "<script>alert('Username is already taken.');
            window.location.href = 'register.php';</script>";
            session_destroy(); // Destroy the session
        }
        else
        {
            // If the username is not taken, SQL statement to insert the new user
            $sql = "INSERT INTO users (username, password, role, full_name) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $password, $role, $full_name);

            // Execute the insert statement and check if it was successful
            if ($stmt->execute())
            {
                // On success, alert the user and redirect to the login page
                echo "<script>alert('Registration successful! You can now login');
                window.location.href = 'login.php';</script>";
                session_destroy(); // Destroy the session after successful registration
            }
            else
            {
                // If there was an error during the insertion, display the error
                echo "Error: " . $stmt->error;
            }
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set and responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    
    <style>
        /* Basic body styling */
        body
        {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        
        /* Container styling for the registration form */
        .container
        {
            margin: 50px auto;
            max-width: 400px;
            padding: 100px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Heading styling */
        h2
        {
            text-align: center;
        }

        /* Styling for form labels */
        label
        {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        /* Styling for input fields and select dropdown */
        input[type="text"], input[type="password"], select
        {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Button styling */
        button
        {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
        }

        /* Hover effect for button */
        button:hover
        {
            background-color: #0056b3;
        }

        /* Error message styling */
        .error
        {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        
        <!-- Registration form -->
        <form action="register.php" method="post">
            <!-- Username input field -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <!-- Full Name input field -->
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required>

            <!-- Password input -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <!-- Confirm Password input field -->
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <!-- Role selection -->
            <label for="role">Select Role</label>
            <select id="role" name="role" required>
                <option value="User">User</option>
                <option value="Tier 1 Agent">Tier 1 Agent</option>
                <option value="Tier 2 Agent">Tier 2 Agent</option>
            </select>

            <!--button for form submission -->
            <button type="submit">Register</button>

            <!-- Link to login page for users -->
            <p></p>
            Have an account? <a href="login.php">Login here</a>
        </form>
    </div>
</body>
</html>
