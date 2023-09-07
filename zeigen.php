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

    // Provera lozinke
    if (isset($_POST['anzeigen'])) {
    $password = $_POST['password'];

    // Provera da li je polje za lozinku prazno
    if (empty($password)) {
        echo "Bitte geben Sie das Passwort ein!";
        exit;
    }

    // Provera da li je lozinka tačna
    if ($password !== '0000') {
        echo "Falsches Passwort!";
        exit;
    }
}

        

    $con = new mysqli("localhost", "root", "", "projekt");
    $sql = "SET NAMES 'utf8'";
    mysqli_query($con, $sql);

    if (isset($_GET['user_lastName'])) {
        $stmt = $con->prepare("SELECT * FROM registration WHERE user_lastName = ?");
        $stmt->bind_param("s", $_GET['user_lastName']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
?>

<form action="conn_loesh.php" method="post">
    <!-- Your form fields here -->
    <input type="hidden" name="user_lastName" value="<?php echo $row['user_lastName']; ?>">
    <input type="submit" name="update2" value="Aktualisieren">
</form>

<?php
    } else {
        $res = mysqli_query($con, "SELECT * FROM registration");
        while ($row = mysqli_fetch_array($res)) {
            echo "<form method='post' action='registration'>";
            echo "$row[0].<br> <b>$row[1] <br> $row[2]</b><br> $row[3]<br> $row[4]<br> $row[5]<br> $row[6]<br> $row[7] $row[8] ";
            echo "<input type='hidden' name='user_lastName' value='$row[2]'>";
            echo "<br><td><a href='update.php?user_lastName=$row[2]'>Bearbeiten</a></td><br>";
            echo "</form>";
            echo "<br>";
        }
    }
?>

<form method="post" action="projekt.html">
    <input type="submit" name="delback" value="Startseite">
</form>

</div>

</body>
</html>
