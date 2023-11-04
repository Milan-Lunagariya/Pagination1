<?php
include "config.php";
$limit = 3;
if (isset($_REQUEST['page'])) {
    $pages = $_REQUEST['page'];
} else {
    $pages = 1;
}
$offset = ($pages - 1) * $limit;
$getRecord = "SELECT * FROM `gallery_formis` LIMIT {$offset},{$limit}";
$res = mysqli_query($con, $getRecord);

if (isset($_REQUEST['del'])) {
    echo "<p style='color:green;'><br>User Deleted Successfully</p>";
}
if (isset($_REQUEST['upd'])) {
    echo "<p style='color:green;'><br>User Updated Successfully</p>";
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <style>
        img {
            /* border: 2px solid black; */
            display: flex;
            width: fit-content;
            background-color: orange;
            margin: auto;
            /* border-radius: 20px; */
        }

        li {
            list-style-type: none;
            margin: 2px;
            /* padding: 3px; */
        }

        ul {
            display: flex;
        }

        .image_container {
            display: grid;
            grid-template-columns: auto auto auto;
            border: 5px solid green;
            width: fit-content;
            background-color: lightblue;
            margin: auto;
            padding: 20px;
            border-radius: 20px;
        }

        .image {
            margin: 5px 5px;
            /* padding: 3px; */
            border: 2px solid black;
            background-color: pink;
            border-radius: 20px;
            padding: 13px;
            width: auto;
            text-align: center;
        }

        .delete-edit {
            display: flex;
            margin: 5px 1px;
            padding: 2px;
        }

        .pagination {
            /* background: brown; */
            padding: 2px;
            width: min-content;
            margin: 14px auto;
        }

        a {
            border: 2px solid black;
            background-color: pink;
            border-radius: 10px;
            padding: 10px;
            margin: 2px auto;
            text-align: center;
            text-decoration: none;
        }

        .active {
            color: white;
            background: black
        }
    </style>
    <script>
        function check_delete() {
            return confirm('Are you sure you want to Delete this Record');
        }
    </script>
</head>

<body>

    <div class="image_container">
        <?php
        while ($data = mysqli_fetch_assoc($res)) {
            ?>
            <div class="image">
                <img src="<?php echo $data['pic'] ?>" alt="Image Not found" width="200px" height="200px"><br>
                <?php echo $data['name']; ?>
                <div class="delete-edit">
                    <a href="index.php?editid=<?php echo $data['id']; ?>">Edit</a>
                    <a href="index.php?delid=<?php echo $data['id']; ?>" onclick="return check_delete()">Delete</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <?php
    $sql_get = "SELECT * FROM `gallery_formis` ";
    $res = mysqli_query($con, $sql_get);

    if (mysqli_num_rows($res) > 0) {
        $total_records = mysqli_num_rows($res);
        $total_pages = ceil($total_records / $limit);

        echo '<div class="pagination">
            <ul>';
        
        if($pages > 1) {
        echo '<li><a href="detail.php?page='.($pages-1).'">Previous</a><li>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $pages) {
                $active = 'active';
            } else {
                $active = '';
            }
            echo '<li  class="' . $active . '"><a href="detail.php?page=' . $i . '">' . $i . '</a></li>';
        }
        if ($total_pages > $pages) {
        echo '<li><a href="detail.php?page='.($pages+1).'">Next</a><li>';
        }
        echo '</ul>
        </div>';
    }
    ?>



</body>

</html>