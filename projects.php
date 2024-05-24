<?php include_once('base/head.php'); ?>
<style>
    img {
            max-width: 100px;
            max-height: 60px;
        }
        tbody, td {
            padding: 15px;
            height: 70px;
            text-align: left;
            max-width: 200px; /* Adjust the width as needed */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
</style>
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

?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Themes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">List Themes</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lorem ipsum dolor sit amet.</h3>

                <div class="card-tools">
                    <a class="btn btn-primary" href="add-themes.php" role="button">Add Themes</a>
                </div>
            </div>
            <div class="table-responsive p-2">
                <table id="example2" class="table  table-striped">
                    <thead>
                    
                        <tr>
                            <th style="width: 0.5%;">
                                #
                            </th>
                            <th style="width: 11%">
                                Category Name
                            </th>
                            <th style="width: 14%">
                                Themes Name
                            </th>
                            <th style="width: 30%">
                                Description
                            </th>
                            <th style="width: 10%">
                                Themes Image
                            </th>
                            <th style="width: 10%">
                                Themes url
                            </th>
                            <th style="width: 15%">
                                <input class="form-control" id="searchInput" type="text" placeholder="Search...">
                            </th>

                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php
                            
                            $result = $conn->query("SELECT theme.*, category.Category FROM theme JOIN category ON theme.category_id = category.id");
                            
                            $counter = 1;

                            if ($result->num_rows > 0) {
                               
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $counter++ . "</td>";
                                    echo "<td>" . $row['Category'] . "</td>"; // Show category name
                                    echo "<td>" . $row['theme_name'] . "</td>";
                                    echo "<td>" . $row['description'] . "</td>";
                                    echo "<td>";
                                    if ($row['image']) {
                                        echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' />";
                                    } else {
                                        echo "No image";
                                    }
                                    echo "</td>";
                                    echo "<td>" . $row['url'] . "</td>";
                                    //echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td class='project-actions text-right'>
                                            <a class='btn btn-info btn-sm' href='add-themes.php'>
                                                <i class='fas fa-pencil-alt'>
                                                </i>
                                                Edit
                                            </a>
                
                                        </td>";
                                    echo "</tr>";
                                }
                                
                            } else {
                                echo "No themes found.";
                            }

                            $conn->close();
                        ?>
                        
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tableBody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<?php include_once('base/foot.php'); ?>