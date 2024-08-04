<?php include_once('base/head.php'); ?>

<?php
$insert = false;

$server = "localhost";
$username = "root";
$password = "";
$database = "admin_project";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profile_image = '';
    $target_dir = "uploads/";

    // Check if the uploads directory exists, if not create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $profile_image = $target_file;
        } else {
            echo "Error: Unable to move uploaded file.";
        }
    }

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $company_address = trim($_POST['company_address']);
    $profile = trim($_POST['profile']);
    $bio = trim($_POST['bio']);
    $link1 = trim($_POST['link1']);
    $link2 = trim($_POST['link2']);
    $link3 = trim($_POST['link3']);
    $link4 = trim($_POST['link4']);
    $link5 = trim($_POST['link5']);

    $stmt = $conn->prepare("INSERT INTO profile_detail (profile_image, full_name, email, phone, company_address, profile, bio, link_1, link_2, link_3, link_4, link_5, time) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, current_timestamp())");

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('sssssssssss', $profile_image, $full_name, $email, $phone, $company_address, $profile, $bio, $link1, $link2, $link3, $link4, $link5);

    if ($stmt->execute()) {
        $insert = true;
        echo "upload Done";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Admin Profile Edit</h3>
      </div>
      <form id="personalDetailsForm" method="post" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-group">
            <label for="inputStatus">Personal Details</label><hr>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Profile Image</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-image-input form-control" id="exampleInputimage" name="profile_image">
              </div>
              <div class="input-group-append">
                <span class="input-group-text">Upload</span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="inputName">Full Name</label>
            <input type="text" id="inputName" name="full_name" class="form-control" placeholder="Amit Gupta">
          </div>
          <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="zxy12@gmail.com">
          </div>
          <div class="form-group">
            <label for="inputPhone">Phone</label>
            <input type="text" id="inputPhone" name="phone" class="form-control" placeholder="9999999999">
          </div>
          <div class="form-group">
            <label for="inputCompanyAddress">Company Address</label>
            <input type="text" id="inputCompanyAddress" name="company_address" class="form-control" placeholder="11, 23, Bhupat Bhavan, Vaju Kotak Mrg, Fort Mumbai">
          </div>
          <div class="form-group">
            <label for="inputProfile">Profile</label>
            <input type="text" id="inputProfile" name="profile" class="form-control" placeholder="CEO">
          </div>
          <div class="form-group">
            <label for="inputBio">Bio</label>
            <input type="text" id="inputBio" name="bio" class="form-control" placeholder="Bio in 150 words">
          </div>
          <div class="form-group">
            <label for="inputStatus">Social Media Links</label><hr>
          </div>
          <div class="form-group">
            <label for="inputWebsite" class="form-label">Website</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="link1" id="inputWebsite" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <div class="form-group">
            <label for="inputGithub" class="form-label">Github</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="link2" id="inputGithub" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <div class="form-group">
            <label for="inputX" class="form-label">X</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="link3" id="inputX" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <div class="form-group">
            <label for="inputInstagram" class="form-label">Instagram</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="link4" id="inputInstagram" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <div class="form-group">
            <label for="inputFacebook" class="form-label">Facebook</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="link5" id="inputFacebook" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-4 w-100">Submit</button>
        </div>
      </form>
      <!-- /.card-body -->
    </div>
    <div id="output" class="mt-5"></div>
    <!-- /.card -->
</div>

<script>
document.getElementById('personalDetailsForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const output = document.getElementById('output');

    let data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    // Handle the image file
    const imageFile = formData.get('profile_image');
    let imageUrl = '';
    if (imageFile) {
        imageUrl = URL.createObjectURL(imageFile);
    }

    let outputHtml = `
        <h2>Submitted Data</h2>
        ${imageUrl ? `<p><strong>Profile Image:</strong><br><img src="${imageUrl}" alt="Profile Image" style="max-width: 100px;"></p>` : ''}
        <p><strong>Full Name:</strong> ${data.full_name}</p>
        <p><strong>Email:</strong> ${data.email}</p>
        <p><strong>Phone:</strong> ${data.phone}</p>
        <p><strong>Company Address:</strong> ${data.company_address}</p>
        <p><strong>Profile:</strong> ${data.profile}</p>
        <p><strong>Bio:</strong> ${data.bio}</p>
        <p><strong>Website:</strong> ${data.link1}</p>
        <p><strong>Github:</strong> ${data.link2}</p>
        <p><strong>X:</strong> ${data.link3}</p>
        <p><strong>Instagram:</strong> ${data.link4}</p>
        <p><strong>Facebook:</strong> ${data.link5}</p>
    `;

    output.innerHTML = outputHtml;
});
</script>
