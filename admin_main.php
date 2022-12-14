<?php
include 'connection.php';
session_start();
if(empty($_SESSION['email'])){
    header('location:index.php?message=not_yet_login');
}
if (isset($_GET['category'])) {
    $id = $_GET['category'];
    $query = "SELECT * FROM item where category_code = $id ORDER BY category_code ASC";
} else {
    $query = "SELECT * FROM item";
}
$category_list = mysqli_query($connect, "SELECT * FROM category");
$query_result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/admin_main.css">
    <title>Admin Page</title>
</head>

<body>
    <div class="navs">
        <div class="logo">
            <h1>Harmonie Beauty</h1>
        </div>
        <div class="nav">
            <li><a class="setting" href="admin.php">Home</a></li>
            <li><a class="setting" href="#">Setting</a></li>
            <li><a class="add" href="admin_add.php"><span>Add +</span></a></li>
            <li>
                <form action="logout.php" method="POST"><input type="submit" value=" Logout"></form>
            </li>
        </div>
    </div>

    <div class="legend">

    </div>

    <div class="container">
        <div class="category">
            <div class="logo-category">
                <h1>Category</h1>
            </div>
            <?php
            while ($row = mysqli_fetch_object($category_list)) {
            ?>
                <div class="list-category">
                    <a style="text-decoration: none" href="admin_main.php?category=<?= $row->ID_category ?>">
                        <p><?= $row->category_name ?></p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="product">
            <div class="cards">

                <?php
                while ($row = mysqli_fetch_object($query_result)) { ?>
                    <div class="card">
                        <div class="image">
                            <?php
                            $image = mysqli_fetch_object(mysqli_query($connect, "SELECT * FROM item INNER JOIN images on item.image_id = images.id WHERE item.item_id=$row->item_id"));
                            ?>
                            <img src="uploads/<?= $image->image_url ?>" alt="">
                        </div>
                        <div class="desc">
                            <p class="title"><?= $row->item_name ?></p>
                            <p class="price">IDR <?= $row->item_price ?></p>
                            <p class="text"><?= $row->item_desc ?></p>
                        </div>
                        <form class="action">
                            <a href="admin_edit.php?id=<?= $row->item_id ?>"><input class="edit" type="submit" value="Edit" form="edit"></a>
                            <a href="admin_delete.php?id=<?= $row->item_id ?>"><input class="delete" type="submit" value="Delete" form="delete"></a>
                        </form>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!--Pesan berhasil nambah item-->
    <p>
        <?php if (isset($_GET['message'])) {
            if ($_GET['message'] == 'success') {
                echo "Data added successfully";
            }
        }
        ?>
    </p>

</body>

</html>