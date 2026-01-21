<?php
include "config/db.php";

$id = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM pickup_points WHERE id=$id"));

if(isset($_POST['update'])){
    $pickup=$_POST['pickup'];
    mysqli_query($conn,"UPDATE pickup_points SET pickup_name='$pickup' WHERE id=$id");
    header("Location: pickup_points.php");
}
?>

<link rel="stylesheet" href="assets/style.css">

<div class="edit-box">
<h3>Edit Pickup Point</h3>

<form method="post">
<input name="pickup" value="<?= $row['pickup_name'] ?>" required>
<button class="btn" name="update">Update</button>
<a href="pickup_points.php" class="btn light">Cancel</a>
</form>
</div>
