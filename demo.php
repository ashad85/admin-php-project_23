<?php
$insert = false;

$server = "localhost";
$username = "root";
$password = "";
$database = "admin_project";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("not connect" . mysqli_connect_errno());
}

if (isset($_POST['category'])) {
    $category = $_POST['category'];

    // Corrected SQL INSERT statement
    $sql = "INSERT INTO `category` (`Category`, `datetime`) VALUES ('$category', current_timestamp())";

    if (mysqli_query($conn, $sql)) {
        $insert = true;
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>View Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Add Category</h1>
    <form class="row g-3 needs-validation p-3" method="post">
        <div class="col-md-4">
            <label for="validationCustom02" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="category" id="validationCustom02" required>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
    </form>
    <h1>Categories</h1>
    <?php
    $result = $conn->query("SELECT * FROM category");

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Category Name</th><th>Created At</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['Category'] . "</td>";
            echo "<td>" . $row['datetime'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No categories found.";
    }
    
    ?>
</body>

</html>
