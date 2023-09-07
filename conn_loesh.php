<?php
    // Error reporting
    error_reporting(E_ALL & ~ E_NOTICE);

    // Database connection
    $con = new mysqli("localhost", "root", "", "projekt");

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Set character encoding
    $sql = "SET NAMES 'utf8'";
    mysqli_query($con, $sql);

    if (isset($_POST['update2'])) {
        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("UPDATE registration SET user_name = ?, user_birthdate = ?, gebOrt = ?, user_email = ?, user_password = ?, user_geschl = ? WHERE user_lastName = ?");
        $stmt->bind_param("sssssss", $_POST['user_name'], $_POST['user_birthdate'], $_POST['gebOrt'], $_POST['user_email'], password_hash($_POST['user_password'], PASSWORD_DEFAULT), $_POST['user_geschl'], $_POST['user_lastName']);
        
        if ($stmt->execute()) {
            echo "<font color='green'>Record Updated Successfully</font>";
        } else {
            echo "<font color='red'>Failed to Update Record</font>";
        }
        
        $stmt->close();
    } else {
        echo "<font color='red'>No POST data to Update</font>";
    }

    echo "<br>";
    echo "<a href='update.php'>Back to Update Page</a>";
?>
