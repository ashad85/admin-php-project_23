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
        // Verify that the file is an image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
        } else {
            echo "Uploaded file is not an image.";
            exit();
        }
    } else {
        // Detailed error messages
        if (!isset($_FILES['image'])) {
            echo "No file was uploaded.";
        } else {
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "The uploaded file was only partially uploaded.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "No file was uploaded.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "Missing a temporary folder.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "Failed to write file to disk.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "A PHP extension stopped the file upload.";
                    break;
                default:
                    echo "Unknown upload error.";
                    break;
            }
        }
        exit();
    }

    // Corrected SQL INSERT statement with placeholders
    $stmt = $conn->prepare("INSERT INTO `theme` (`category_id`, `theme_name`, `description`, `image`, `url`, `created_at`) 
                            VALUES (?, ?, ?, ?, ?, current_timestamp())");

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("issss", $category_id, $theme_name, $description, $image, $url);

    if ($stmt->execute()) {
        $insert = true;
        header("Location: projects.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
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
                    <input type="file" class="custom-image-input form-control" id="exampleInputimage" name="image" required>
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
