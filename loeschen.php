<!DOCTYPE html>
<html>
<head>
    <title>Vaša stranica</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
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

    if (isset($_POST['delete'])) {
        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("DELETE FROM registration WHERE user_email = ?");
        $stmt->bind_param("s", $_POST['user_email']);
        $stmt->execute();
        $stmt->close();
        header("Location: update.php");
    } elseif (isset($_POST['update'])) {
        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM registration WHERE user_email = ?");
        $stmt->bind_param("s", $_POST['user_email']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
?>

<form action="aktualisieren.php" method="post">
    <?php
        echo "ID: $row[id] <br>";
        echo "Name: <input type='text' name='user_name' value='$row[user_name]'><br>";
        echo "Nachname: <input type='text' name='user_lastName' value='$row[user_lastName]'><br>";
        echo "Geburtsdatum: <input type='date' name='user_birthdate' value='$row[user_birthdate]'><br>";
        echo "Bundesland: ";
    ?>
    <select name="gebOrt">
        <option value="Niederösterreich" <?php if($row['gebOrt'] == 'Niederösterreich') echo 'selected'; ?>>Niederösterreich</option>
        <option value="Wien" <?php if($row['gebOrt'] == 'Wien') echo 'selected'; ?>>Wien</option>
        <option value="Steiermark" <?php if($row['gebOrt'] == 'Steiermark') echo 'selected'; ?>>Steiermark</option>
        <option value="Voralberg" <?php if($row['gebOrt'] == 'Voralberg') echo 'selected'; ?>>Voralberg</option>
        <option value="Kärnten" <?php if($row['gebOrt'] == 'Kärnten') echo 'selected'; ?>>Kärnten</option>
        <option value="Oberösterreich" <?php if($row['gebOrt'] == 'Oberösterreich') echo 'selected'; ?>>Oberösterreich</option>
        <option value="Tirol" <?php if($row['gebOrt'] == 'Tirol') echo 'selected'; ?>>Tirol</option>
        <option value="Salzburg" <?php if($row['gebOrt'] == 'Salzburg') echo 'selected'; ?>>Salzburg</option>
        <option value="Burgenland" <?php if($row['gebOrt'] == 'Burgenland') echo 'selected'; ?>>Burgenland</option>
    </select>
    <br>
    <?php
        echo "E-Mail: <input type='email' name='user_email' value='$row[user_email]'><br>";
        echo "Password: <input type='password' name='user_password' value='$row[user_password]'><br>";
        echo "Geschlecht: ";
    ?>
    <select name="user_geschl">
        <option value="Männlich" <?php if($row['user_geschl'] == 'Männlich') echo 'selected'; ?>>Männlich</option>
        <option value="Weiblich" <?php if($row['user_geschl'] == 'Weiblich') echo 'selected'; ?>>Weiblich</option>
    </select>
    <br>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="submit" name="update2" value="Aktualisieren">
</form>



<?php
    }
?>

<form method="post" action="projekt.html">
    <input type="submit" name="back" value="Zurück zur Startseite">
</form>

</div>

</body>
</html>
