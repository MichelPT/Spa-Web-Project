<?php
include 'connection.php';
session_start();
if(empty($_SESSION['email'])){
    header('location:index.php?message=not_yet_login');
}
$item_id = $_GET['id'];
$query = mysqli_query($connect, "SELECT * FROM category");
$data = mysqli_fetch_object(mysqli_query($connect, "SELECT * FROM item inner join category on item.category_code=category.ID_category WHERE item.item_id = $item_id"));

?>

<!DOCTYPE html>
<html lang="en">

<head>
       <meta charset="UTF-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Input Data</title>
       <link rel="stylesheet" href="style/admin_add.css">
</head>

<body>
       <div class="container">
              <div class="sidebar">
                     <div class="logo">
                            <h1>Harmonie</h1>
                     </div>
                     <div class="list">
                            <div class="menu-list">
                                   <a href="admin.php">Home</a>
                            </div>
                            <div class="menu-list">
                                   <a href="#">Setting</a>
                            </div>
                            <div class="menu-list">
                                   <a href="#">Logout</a>
                            </div>
                     </div>

              </div>
              <div class="field">
                     <form class="fill" action="product_add.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="name" placeholder="Product name" value="<?= $data->item_name ?>" required>
                            <select name="category" required>
                                   <option value="<?= $data->ID_category ?>" disabled selected hidden><?= $data->category_name ?></option>
                                   <?php
                                   while ($data_category = mysqli_fetch_object($query)) {
                                   ?> <option value="<?= $data_category->category_name ?>"><?= $data_category->category_name ?></option>
                                   <?php
                                   }
                                   ?>
                            </select>
                            <input class="price" type="text" name="price" placeholder="Product Price" value="<?= $data->item_price ?>" required>
                            <input class="info" type="text" name="info" placeholder="Product Info" value="<?= $data->item_info ?>" required>
                            <input class="desc" type="text" name="desc" placeholder="Product Description" value="<?= $data->item_desc ?>" required>
                            <input class="image" type="file" name="product_image" required>
                            <input class="submit" type="submit" name="submit" value="Upload">
                     </form>
              </div>
              <!--Bagian input gambar dan pesan errornya, pesan errornya duluan tapi-->
              <?php if (isset($_GET['error'])) : ?>
                     <p><?= $_GET['error']; ?></p>
              <?php endif ?>
       </div>
</body>

</html>