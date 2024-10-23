<?php
// Start session
session_start();

// Check if the user is logged in by verifying if the session variable is set
if (!isset($_SESSION['username'])) 
{
    // User is not logged in
    echo "<script>
            alert('You are not logged in. Please log in to continue.');
            window.location.href = 'login.php';
          </script>";
    exit();
}

// Check if the user role is 'user'
if ($_SESSION['role'] !== 'user') 
{
    // User is logged in but not a regular user
    echo "<script>
            alert('Access denied: You do not have permission to access this page.');
            window.location.href = 'logout.php'; // Change to the appropriate dashboard
          </script>";
    exit();
}

// Retrieve the username from the session
$username1 = $_SESSION['username'];

// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "support_system"; 

// Create a new MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute a query to retrieve the user's tickets
$sql = "SELECT ticket_id, subject, description, status, created_at FROM tickets WHERE username = ?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param('s', $username1); 
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    
    <style>
        /* Basic styling for the page layout */
        body 
        {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Container for the dashboard */
        .container 
        {
            margin: 50px auto;
            max-width: 800px;
            padding: 100px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        /* Center the heading */
        h2 
        {
            text-align: center;
        }

        /* Styling for the ticket table */
        table 
        {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td 
        {
            border: 1px solid #ddd;
        }

        th, td 
        {
            padding: 12px;
            text-align: left;
        }

        th 
        {
            background-color: #007bff;
            color: white;
        }

        /* Styling for buttons */
        button.escalate, button.close 
        {
            padding: 5px 10px;
            background-color: #ffc107;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button.escalate:hover, button.close:hover 
        {
            background-color: #ff9500;
        }

        /* Styling for logout button */
        .logout-button 
        {
            display: block;
            width: 25%;
            padding: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
        }

        .logout-button:hover 
        {
            background-color: #c82333;
        } 

        /* Styling for ticket submission form */
        .ticket-form 
        {
            margin-top: 50px;
        }

        .input-group 
        {
            margin-bottom: 15px;
        }

        label 
        {
            display: block;
            font-weight: bold;
        }

        input[type="text"], textarea 
        {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] 
        {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover 
        {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Display a personalized welcome message using the session variable -->
        <h2>Welcome, <?php echo htmlspecialchars($username1); ?>!</h2>

        <!-- Ticket Submission Form -->
        <div class="ticket-form">
            <h3>Submit a New Ticket</h3>
            <form action="submit_ticket.php" method="post">
                <div class="input-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="input-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="5" required></textarea>
                </div>
                <button type="submit">Submit Ticket</button>
            </form>
        </div>

        <!-- Display the user's tickets -->
        <h3>My Tickets</h3>
        <table>
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if the user has any tickets
                if ($result->num_rows > 0) 
                {
                    // Output data for each ticket
                    while ($row = $result->fetch_assoc()) 
                    {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['ticket_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "<td>";
                        
                        // Show the close button for open, resolved, or escalated tickets
                        if ($row['status'] === 'Open' || $row['status'] === 'Resolved' || $row['status'] === 'Escalated') 
                        {
                            echo "<form action='close_ticket.php' method='post'>";
                            echo "<input type='hidden' name='ticket_id' value='" . $row['ticket_id'] . "'>";
                            echo "<button class='close' type='submit'>Close Ticket</button>";
                            echo "</form>";
                        } 
                        else 
                        {
                            echo "No actions available";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } 
                else 
                {
                    echo "<tr><td colspan='6'>You have not submitted any tickets yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Logout Button -->
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection and statement
$stmt->close();
$conn->close();
?>