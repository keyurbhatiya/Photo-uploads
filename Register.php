<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register Page</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }
    .container {
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
    }
    input[type="text"],
    input[type="number"],
    input[type="tel"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        width: 100%;
        background-color: #4caf50;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
    .error {
        color: red;
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="" method="post">
            <label for="user_id">User ID</label>
            <input type="text" id="user_id" name="user_id" required>

            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="num_photos">Number of Photos</label>
            <input type="number" id="num_photos" name="num_photos" min="0" required>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="re_password">Re-enter Password</label>
            <input type="password" id="re_password" name="re_password" required>

            <input type="submit" name="submit" value="Login">
        </form>
    </div>

<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php_task";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if(isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $num_photos = $_POST['num_photos'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    
    // Insert data into database
    $sql = "INSERT INTO users (user_id, name, num_photos, phone, password) VALUES ('$user_id', '$name', '$num_photos', '$phone', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>New record created successfully</p>";
        header("Location: adphoto.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>

</body>
</html>
