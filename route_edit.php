<?php
include "config/db.php";

$id = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM routes WHERE id=$id"));

if(isset($_POST['update'])){
    $route=$_POST['route'];
    mysqli_query($conn,"UPDATE routes SET route_name='$route' WHERE id=$id");
    header("Location: routes.php");
}
?>

<link rel="stylesheet" href="assets/style.css">

<div class="edit-box">
<h3>Edit Route</h3>

<form method="post">
<input name="route" value="<?= $row['route_name'] ?>" required>
<button class="btn" name="update">Update</button>
<a href="routes.php" class="btn light">Cancel</a>
</form>
</div>
