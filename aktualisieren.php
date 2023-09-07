<!DOCTYPE html>
<html>
<head>
    <title>Vaša stranica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .message {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid;
            border-radius: 4px;
        }
        .success {
            color: #4F8A10;
            background-color: #DFF2BF;
            border-color: #4F8A10;
        }
        .error {
            color: #D8000C;
            background-color: #FFBABA;
            border-color: #D8000C;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">

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
        $stmt = $con->prepare("UPDATE registration SET user_name = ?, user_lastName = ?, user_birthdate = ?, gebOrt = ?, user_email = ?, user_password = ?, user_geschl = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $_POST['user_name'], $_POST['user_lastName'], $_POST['user_birthdate'], $_POST['gebOrt'], $_POST['user_email'], password_hash($_POST['user_password'], PASSWORD_DEFAULT), $_POST['user_geschl'], $_POST['id']);
     
        
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

</div>

</body>
</html>
