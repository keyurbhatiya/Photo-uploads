<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Photos</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }
    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
    }
    .photo {
        margin-bottom: 20px;
        text-align: center;
    }
    .photo img {
        max-width: 300px;
        height: auto;
        display: block;
        margin: 0 auto;
    }
    .status-dropdown {
        margin-bottom: 10px;
    }
    input[type="text"],
    select,
    input[type="submit"],.log-out {
        width: 11%;
        padding: 3px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type="submit"],.log-out {
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type="submit"],.log-out:hover {
        background-color: #45a049;
    }
  

</style>
</head>
<body>
    <div class="container">
        <h2>All Photos</h2>
        <div class="photos">
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

            // SQL query to retrieve all photos
            $sql = "SELECT * FROM photos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each photo
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='photo'>";
                    echo "<img src='" . $row['photo_path'] . "' alt='Photo'>";
                    echo "<p>User ID: " . $row['user_id'] . "</p>";
                    echo "<form action='#' method='post'>";
                    echo "<input type='hidden' name='photo_id' value='" . $row['id'] . "'>";
                    echo "<label for='status_" . $row['id'] . "'>Update Status:</label>";
                    echo "&nbsp";
                    echo "<select id='status_" . $row['id'] . "' name='status' class='status-dropdown'>";
                    echo "<option value='1' " . ($row['is_active'] == 1 ? 'selected' : '') . ">Active</option>";
                    echo "<option value='0' " . ($row['is_active'] == 0 ? 'selected' : '') . ">Inactive</option>";
                    echo "&nbsp";
                    echo "</select>";
                    echo "&nbsp";
                    echo "<br/>";
                    echo "<input type='submit' name='submit' value='Update'>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "No photos found.";
            }

            // Close connection
            $conn->close();
            ?>
        </div>
        <?php
        // Handle individual photo status update
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

            // Get photo ID and status value from the form
            $photo_id = $_POST['photo_id'];
            $status = $_POST['status'];

            // SQL query to update status for the selected photo
            $sql = "UPDATE photos SET is_active = ? WHERE id = ?";

            // Prepare and execute statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $status, $photo_id);
            if ($stmt->execute()) {
                echo "<p>Status updated successfully for photo ID: " . $photo_id . "!</p>";
            } else {
                echo "Error updating status: " . $conn->error;
            }

            // Close connection
            $conn->close();
        }
        ?>
        <button class="log-out"><a href="Register.php">Log-out</a></button>

    </div>
</body>
</html>
