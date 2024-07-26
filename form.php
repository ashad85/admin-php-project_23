<?php
ob_start(); // Start output buffering
include_once('base/head.php'); // Ensure this is included after ob_start()

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

    // Corrected SQL INSERT statement with prepared statement
    $stmt = $conn->prepare("INSERT INTO `theme` (`category_id`, `theme_name`, `description`, `image`, `url`, `created_at`) 
                            VALUES ('$category_id', '$theme_name', '$description', '$image', '$url', current_timestamp())");

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

include_once('base/foot.php');
ob_end_flush(); // End output buffering and flush output
?>
