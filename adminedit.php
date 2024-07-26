<?php include_once('base/head.php'); ?>

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
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Admin Profile Edit</h3>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-group">
            <label for="inputStatus">Personal Details</label><hr>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Profile Image</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-image-input form-control" id="exampleInputimage" name="image">
                </div>
                <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                </div>
            </div>
          </div>
          <div class="form-group">
            <label for="inputName">Full Name</label>
            <input type="text" id="inputName" name="full_name" class="form-control"placeholder="Amit Gupta">
          </div>
          <div class="form-group">
            <label for="inputName">Email</label>
            <input type="email" id="inputName" name="email" class="form-control"placeholder="zxy12@gmail.com">
          </div>
          <div class="form-group">
            <label for="inputName">Phone</label>
            <input type="text" id="inputName" name="phone" class="form-control" placeholder="9999999999">
          </div>
          <div class="form-group">
            <label for="inputName">Company Address</label>
            <input type="text" id="inputName" name="company_address" class="form-control" placeholder="11, 23, Bhupat Bhavan, Vaju Kotak Mrg, Fort Mumbai">
          </div>
          <div class="form-group">
            <label for="inputName">Profile</label>
            <input type="text" id="inputName" name="profile" class="form-control" placeholder="CEO">
          </div>
          <div class="form-group">
            <label for="inputName">Bio</label>
            <input type="text" id="inputName" name="bio" class="form-control" placeholder="Bio in 150 word">
          </div>
          <div class="form-group">
            <label for="inputStatus">Social Media Line</label><hr>
          </div>
          <div class="form-group">
            <label for="basic-url" class="form-label">Web Site</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="Web_site" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <div class="form-group">
            <label for="basic-url" class="form-label">Github</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="github" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <div class="form-group">
            <label for="basic-url" class="form-label">X</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="x" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <div class="form-group">
            <label for="basic-url" class="form-label">Instagram</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="insta" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <div class="form-group">
            <label for="basic-url" class="form-label">Facebook</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
              <input type="text" class="form-control" name="facebook" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-4 w-100">Submit</button>
        </div>
      </form>
      <!-- /.card-body -->
    </div>
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

    let outputHtml = `
        <h2>Submitted Data</h2>
        <p><strong>Full Name:</strong> ${data.full_name}</p>
        <p><strong>Email:</strong> ${data.email}</p>
        <p><strong>Phone:</strong> ${data.phone}</p>
        <p><strong>Company Address:</strong> ${data.company_address}</p>
        <p><strong>Profile:</strong> ${data.profile}</p>
        <p><strong>Bio:</strong> ${data.bio}</p>
        <p><strong>Website:</strong> https://example.com/users/${data.Web_site}</p>
        <p><strong>Github:</strong> https://example.com/users/${data.github}</p>
        <p><strong>X:</strong> https://example.com/users/${data.x}</p>
        <p><strong>Instagram:</strong> https://example.com/users/${data.insta}</p>
        <p><strong>Facebook:</strong> https://example.com/users/${data.facebook}</p>
    `;

    output.innerHTML = outputHtml;
});

</script>

<?php include_once('base/foot.php'); ?>