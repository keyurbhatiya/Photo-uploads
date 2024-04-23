<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Photo</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }
    .container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
    }
    input[type="text"],
    input[type="file"],
    select,
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Add Photo</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="user_id">User ID</label>
            <input type="text" id="user_id" name="user_id" required>

            <label for="photo">Upload Photo</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>

            <label for="is_active">Is Active</label>
            <select id="is_active" name="is_active" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>

            <input type="submit" name="submit" value="Add Photo">
        </form>
    </div>

    <?php
if(isset($_POST['submit'])) {
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

    // Prepare data for insertion
    $user_id = $_POST['user_id'];
    $is_active = $_POST['is_active'];

    // Upload photo
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["photo"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " has been uploaded.";
            // SQL query to insert data into the photos table
            $photo_path = $target_file;
            $sql = "INSERT INTO photos (user_id, photo_path, is_active) VALUES ('$user_id', '$photo_path', '$is_active')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>New photo added successfully!</p>";
                // Redirect to view1.php after successful upload
                header("Location: show.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Close connection
    $conn->close();
}
?>


</body>
</html>
