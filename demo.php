<?php 
ob_start(); // Start output buffering
include_once('base/head.php'); // Ensure this is included after ob_start()
?>

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

if (isset($_POST['theme_name'])) {
    $category_id = $_POST['category_id'];
    $theme_name = $_POST['theme_name'];
    $description = $_POST['description'];
    $url = $_POST['url'];
    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    }

    // Corrected SQL INSERT statement
    $sql = "INSERT INTO `theme` (`category_id`, `theme_name`, `description`, `image`, `url`, `created_at`) 
            VALUES ('$category_id', '$theme_name', '$description', '$image', '$url', current_timestamp())";

    if (mysqli_query($conn, $sql)) {
        $insert = true;
        header("Location: projects.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
          <h1>Add Themes</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Themes</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">General</h3>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-group">
            <label for="inputStatus">Which Category</label>
            <select id="inputStatus" class="form-control custom-select" name="category_id" required>
              <option selected disabled>Select one</option>
              <?php
                    $result = $conn->query("SELECT * FROM category");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['Category']}</option>";
                        }
                    }
                    ?>
            </select>
          </div>
          <div class="form-group">
            <label for="inputName">Theme Name</label>
            <input type="text" id="inputName" name="theme_name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="inputDescription">Description</label>
            <textarea id="inputDescription" name="description" class="form-control" rows="4" required></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">File input</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                <label class="custom-file-label" for="exampleInputFile">Choose image</label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text">Upload</span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="basic-url" class="form-label">Your vanity URL</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="url" id="basic-url" aria-describedby="basic-addon3 basic-addon4" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-4 w-100">Submit</button>
        </div>
      </form>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php 
include_once('base/foot.php'); 
ob_end_flush(); // End output buffering and flush output
?>
