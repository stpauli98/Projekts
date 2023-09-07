<?php
    include("connect.php");
    error_reporting(E_ALL & ~ E_NOTICE);

    if (isset($_POST['user_lastName'])) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM registration WHERE user_lastName = ?");
        $stmt->bind_param("s", $_POST['user_lastName']);

        // Execute the query and check for errors
        if ($stmt->execute()) {
            echo "<span style='color:green;'>Record Deleted from Database</span>";
        } else {
            echo "<span style='color:red;'>Failed to delete records from database</span>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<span style='color:red;'>No last name provided</span>";
    }

    echo "<br>";
    echo "<a href='zeigen.php'>Zeigen</a>";
?>
