<?php
include "config/db.php";

if(isset($_POST['save'])){
    $name = $_POST['vehicle_name'];
    $img = '';

    if(!empty($_FILES['image']['name'])){
        $img = time().$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],"assets/vehicles/".$img);
    }

    mysqli_query($conn,
    "INSERT INTO vehicles_master(vehicle_name,vehicle_image)
     VALUES('$name','$img')");
}
?>
<form method="post" enctype="multipart/form-data">
<input type="text" name="vehicle_name" placeholder="Vehicle Name" required>
<input type="file" name="image">
<button name="save">Save Vehicle</button>
</form>
