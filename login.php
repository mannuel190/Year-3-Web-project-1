<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta information for character set and viewport configuration -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <style>
        /* Basic styling for the page layout */
        body
        {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Styling for the login form container */
        .login-container
        {
            background-color: white;
            padding: 100px; /* Set the padding to 100px */
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        /* Center the form heading */
        h2
        {
            text-align: center;
        }

        /* Input group styling */
        .input-group
        {
            margin-bottom: 15px;
        }

        /* Label styling */
        label
        {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Input fields styling */
        input[type="text"], input[type="password"]
        {
            width: 100%;
            padding: 10px;
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
            cursor: pointer;
        }

        /* Button hover effect */
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
    <!-- Login container to center the form -->
    <div class="login-container">
        <!-- Heading for the login form -->
        <h2>Login</h2>

        <!-- Error message container, displayed when there's an error -->
        <div class="error" id="error-message">
            <?php
            // Display error message if there was a login error
            if (isset($_GET['error'])) 
            {
                echo $_GET['error'];
            }
            ?>
        </div>

        <!-- Login form submission to process_login.php -->
        <form action="process_login.php" method="post">
            <div class="input-group">
                <!-- Username label and input field -->
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="input-group">
                <!-- Password label and input field -->
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <!-- Login button to submit the form -->
            <button type="submit">Login</button>

            <!-- Link to the registration page for new users -->
            <p></p>
            <div>
                Haven't got an account? <a href="register.php">Register here</a>
            </div>
        </form>
    </div>
</body>
</html>
