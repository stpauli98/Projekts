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
    error_reporting(E_ALL & ~ E_NOTICE);

    // Provera lozinke i imena
    if (isset($_POST['suchen'])) {
        $password = $_POST['password'];
        $user_lastName = $_POST['user_lastName'];

        // Provera da li su polja prazna
        if (empty($password) || empty($user_lastName)) {
            echo "Bitte füllen Sie alle Felder aus!";
            exit;
        }

        // Provera da li je lozinka tačna
        if ($password !== '0000') {
            echo "Falsches Passwort!";
            exit;
        }

        // Connect to the database
        $con = new mysqli("localhost", "root", "", "projekt");

        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM registration WHERE user_lastName = ?");
        $stmt->bind_param("s", $user_lastName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "Nachname nicht gefunden!";
            exit;
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo htmlspecialchars($row['user_name']) . "<br>";
                echo htmlspecialchars($row['user_lastName']) . "<br>";
                echo htmlspecialchars($row['user_birthdate']) . "<br>";
                echo htmlspecialchars($row['gebOrt']) . "<br>";
                echo htmlspecialchars($row['user_email']) . "<br>";
                echo htmlspecialchars($row['user_geschl']) . "<br>";
                echo "<td><a href='update.php?user_lastName=$row[user_lastName]'>Bearbeiten</a></td><br><br>";
            }
        } else {
            echo "No records found.";
        }

        // Close the statement and connection
        $stmt->close();
        $con->close();
    }
?>

<br>
<form method="post" action="projekt.html">
    <input type="submit" name="back" value="Zurück zur Startseite">
</form>

</div>

</body>
</html>
