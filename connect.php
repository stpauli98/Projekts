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

// Sanitize and validate user input
$user_name = htmlspecialchars($_POST['user_name']);
$user_lastName = htmlspecialchars($_POST['user_lastName']);
$user_birthdate = htmlspecialchars($_POST['user_birthdate']);
$gebOrt = htmlspecialchars($_POST['gebOrt']);
$user_email = htmlspecialchars($_POST['user_email']);
$user_password = htmlspecialchars($_POST['user_password']);
$user_geschl = htmlspecialchars($_POST['user_geschl']);

// Connect to the database
$conn = new mysqli("localhost", "root", "", "projekt");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email already exists
$emailCheck = "SELECT * FROM registration WHERE user_email = ?";
$stmt = $conn->prepare($emailCheck);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Email address already in use.";
} else {
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO registration VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $user_name, $user_lastName, $user_birthdate, $gebOrt, $user_email, password_hash($user_password, PASSWORD_DEFAULT), $user_geschl);

    // Execute the query and check for errors
    if ($stmt->execute()) {
        echo "New record created successfully<br>";
        echo "Folgende Daten wurden hinzugefügt:<br><br>";
        echo "Name: $user_name<br>";
        echo "Nachname: $user_lastName<br>";
        echo "Geburtsdatum: $user_birthdate<br>";
        echo "Bundesland: $gebOrt<br>";
        echo "E-Mail: $user_email<br>";
        echo "Geschlecht: $user_geschl<br>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();

?>

<br>
<form method="post" action="projekt.html">
    <input type="submit" name="back" value="Zurück zur Startseite">
</form>

</div>

</body>
</html>
