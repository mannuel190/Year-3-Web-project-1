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

// Check if the user role is 'tier 2 agent'
if ($_SESSION['role'] !== 'tier 2 agent') 
{
    //not a tier 2 agent
    echo "<script>
            alert('Access denied: You do not have permission to access this page.');
            window.location.href = 'logout.php'; // Redirect to logout or a different page
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set and responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard - Escalated Tickets</title>
    
    <style>
        /* body styling */
        body
        {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* dashboard */
        .container
        {
            margin: 50px auto;
            max-width: 800px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2
        {
            text-align: center;
        }

         /* Styling for the search form */
         .search-form
        {
            margin-bottom: 20px;
        }

        input[type="text"]
        {
            padding: 8px;
            width: 70%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-button
        {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Styling for tickets table*/
        table
        {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Border and padding for table */
        table, th, td
        {
            border: 1px solid #ddd;
        }

        th, td
        {
            padding: 12px;
            text-align: left;
        }

        /* Header row background color */
        th
        {
            background-color: #007bff;
            color: white;
        }

        /* Styling for the action buttons */
        button
        {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Button hover effect */
        button:hover
        {
            opacity: 0.8;
        }

        /* Styling for the logout button */
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
    </style>
</head>

<body>
    <!-- Dashboard container -->
    <div class="container">
        <h2>Tier 2 Agent Dashboard - Escalated Tickets</h2>

        <!-- Search form -->
        <form class="search-form" method="post">
        <input type="text" name="search" placeholder="Search tickets by subject or description">
        <button type="submit" class="search-button">Search</button>
        </form>
        
        <!-- Table displaying escalated tickets -->
        <table>
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection details
                $servername = "localhost";
                $username = "root";
                $password = ""; 
                $dbname = "support_system";
                
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                if ($conn->connect_error)
                {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if search query is submitted
                $search = isset($_POST['search']) ? $_POST['search'] : '';

                //SQL query based on whether a search term is provided
                if ($search) 
                {
                    $sql = "SELECT ticket_id, subject, description, status 
                            FROM tickets 
                            WHERE status = 'Escalated' 
                            AND (subject LIKE '%$search%' OR description LIKE '%$search%')";
                } 
                else 
                { 
                    // SQL query to select all escalated tickets
                    $sql = "SELECT ticket_id, subject, description, status FROM tickets WHERE status = 'Escalated'";
                }
                
                $result = $conn->query($sql);

                // Check if any escalated tickets are found
                if ($result->num_rows > 0)
                {
                    // Loop through each ticket and display it in table 
                    while ($row = $result->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "<td>" . $row['ticket_id'] . "</td>";
                        echo "<td>" . $row['subject'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>";

                        echo "<p>";

                        // Form for resolving the ticket
                        echo "<form style='display:inline;' action='resolve_ticket.php' method='post'>";
                        echo "<input type='hidden' name='ticket_id' value='" . $row['ticket_id'] . "'>";
                        echo "<button type='submit'>Resolve</button>";
                        echo "</form>";

                        echo "<p>";

                        echo "</td>";
                        echo "</tr>";
                    }
                }
                else
                {
                    // If no escalated tickets are found, display a message
                    echo "<tr><td colspan='5'>No escalated tickets found</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>

        <!-- Logout button -->
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</body>
</html>
