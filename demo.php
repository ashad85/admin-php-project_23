<?php include_once('base/head.php'); ?>

<?php
$insert = false;

$server = "localhost";
$username = "root";
$password = "";
$database = "admin_project";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_errno());
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM `category` WHERE `id` = $delete_id";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: demo.php"); // Redirect to the list page after deletion
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Handle insert request
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

// Pagination logic
$limit = 10; // Number of entries to show per page
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $limit;

// Fetching data with limit
$sql = "SELECT * FROM category LIMIT $start_from, $limit";
$rs_result = $conn->query($sql);

// Getting the total number of records
$sql_total = "SELECT COUNT(id) FROM category";
$rs_total = $conn->query($sql_total);
$row_total = $rs_total->fetch_row();
$total_records = $row_total[0];
$total_pages = ceil($total_records / $limit);
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">List Category</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="container mb-3">
        <form method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Add Category</label>
                <input type="text" class="form-control" name="category" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Lorem ipsum, dolor sit amet consectetur adipisicing.</div>
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
                            <h3 class="card-title m-1">Add more Category </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="table-responsive p-2">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Category Id</th>
                                        <th>Category Name</th>
                                        <th>Date and Time</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = $start_from + 1; // Initialize counter
                                    if ($rs_result->num_rows > 0) {
                                        while ($row = $rs_result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $counter++ . "</td>";
                                            echo "<td>" . $row['Category'] . "</td>";
                                            echo "<td>" . $row['datetime'] . "</td>";
                                            echo "<td class='project-actions text-right'>
                                                    <a class='btn btn-danger btn-sm' href='demo.php?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this category?\")'>
                                                        <i class='fas fa-trash'></i> Delete
                                                    </a>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No categories found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
<!-- /.content-wrapper -->

<?php include_once('base/foot.php'); ?>