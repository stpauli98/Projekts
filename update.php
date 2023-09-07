<!DOCTYPE html>
<html>
<head>
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
    $con = new mysqli("localhost", "root", "", "projekt");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $sql = "SET NAMES 'utf8'";
    mysqli_query($con, $sql);
?>

<b>Testpersonen bearbeiten oder löschen!</b>
<br>

<?php
    $result = mysqli_query($con, "SELECT * FROM registration");
    while ($row = mysqli_fetch_array($result)) {
?>

<form action="loeschen.php" method="post">
    <?php
        echo "ID: $row[0] <br>";
        echo "Name: $row[1] <br>";
        echo "Nachname: $row[2] <br>";
        echo "Geburtsdatum: $row[3] <br>";
        echo "Wohnort: $row[4] <br>";
        echo "E-Mail: $row[5] <br>";
        echo "Password: $row[6] <br>";
        echo "Geschlecht: $row[7] <br>";
    ?>
    <input type="hidden" name="user_email" value="<?php echo $row[5]; ?>">
    <input type="submit" name="update" value="Bearbeiten">
    <input type="submit" name="delete" value="Löschen">
</form>

<?php
        echo "<br>";
    }
?>

<br>
<p>Zurück zur <a href="projekt.html">Startseite</a></p>

</div>

</body>
</html>
