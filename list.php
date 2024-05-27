<?php 
ob_start(); // Start output buffering
include_once('base/head.php');
?>
<?php
include_once('base/head.php');

// Database connection
$server = "localhost";
$username = "root";
$password = "";
$database = "admin_project";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert category
if (isset($_POST['category'])) {
    $category = $_POST['category'];

    $sql = "INSERT INTO `category` (`Category`, `datetime`) VALUES ('$category', current_timestamp())";

    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Delete category
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM `category` WHERE `id` = $delete_id";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">List Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-3">
        <form method="post">
            <div class="mb-3">
                <label for="category" class="form-label">Add Category</label>
                <input type="text" class="form-control" name="category" id="category" aria-describedby="categoryHelp" required>
                <div id="categoryHelp" class="form-text">Lorem ipsum, dolor sit amet consectetur adipisicing.</div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title m-1">Add more Category</h3>
                        </div>
                        <div class="table-responsive p-2">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Serial No.</th>
                                        <th  style="width: 30%">Category Name</th>
                                        <th style="width: 30%">Date and Time</th>
                                        <th style="width: 15%">Total Themes</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "
                                        SELECT 
                                            c.id, 
                                            c.Category, 
                                            c.datetime, 
                                            COUNT(t.id) AS theme_count
                                        FROM 
                                            category c
                                        LEFT JOIN 
                                            theme t 
                                        ON 
                                            c.id = t.category_id
                                        GROUP BY 
                                            c.id, 
                                            c.Category, 
                                            c.datetime
                                    ";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $counter = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $counter++ . "</td>";
                                            echo "<td>" . $row['Category'] . "</td>";
                                            echo "<td>" . $row['datetime'] . "</td>";
                                            echo "<td>" . $row['theme_count'] . "</td>";
                                            echo "<td class='project-actions text-right'>
                                                    <a class='btn btn-danger btn-sm' href='list.php?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this category?\")'>
                                                        <i class='fas fa-trash'></i> Delete
                                                    </a>
                                                </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "No categories found.";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>


<?php include_once('base/foot.php'); 
ob_end_flush(); // Flush the output buffer
?>
