<?php include_once('base/head.php'); ?>

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
      <div class="card-body">
        <div class="form-group">
          <label for="inputStatus">Which Category</label>
          <select id="inputStatus" class="form-control custom-select">
            <option selected disabled>Select one</option>
            <option>IT</option>
            <option>business</option>
            <option>business category Arrangement</option>
          </select>
        </div>
        <div class="form-group">
          <label for="inputName">Theme Name</label>
          <input type="text" id="inputName" class="form-control">
        </div>
        <div class="form-group">
          <label for="inputDescription">Description</label>
          <textarea id="inputDescription" class="form-control" rows="4"></textarea>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">File input</label>
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="exampleInputFile">
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
            <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
          </div>
        </div>
        <button type="button" class="btn btn-primary mt-4 w-100">Submit</button>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once('base/foot.php'); ?>