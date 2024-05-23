<!DOCTYPE html>
<html>
<head>
    <title>Filterable Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        td img {
            max-height: 50px;
            width: auto;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Themes</h1>
    <input class="form-control" id="searchInput" type="text" placeholder="Search...">
    <table class="table table-bordered table-striped mt-3">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Theme Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>URL</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            $server = "localhost";
            $username = "root";
            $password = "";
            $database = "admin_project";

            $conn = mysqli_connect($server, $username, $password, $database);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_errno());
            }

            $result = $conn->query("SELECT theme.*, category.Category FROM theme INNER JOIN category ON theme.category_id = category.id");

            if ($result->num_rows > 0) {
                $counter = 1; // Initialize counter
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $counter++ . "</td>"; // Use counter value
                    echo "<td>" . $row['Category'] . "</td>";
                    echo "<td>" . $row['theme_name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td style='height: 10px;'>"; // Set the height of the cell
                    if ($row['image']) {
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' />";
                    } else {
                        echo "No image";
                    }
                    echo "</td>";
                    echo "<td>" . $row['url'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No themes found.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

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
</body>
</html>
