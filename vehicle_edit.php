<?php
include "config/db.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM vehicles WHERE id=$id"));

if(isset($_POST['update'])){
    $vehicle=$_POST['vehicle'];
    $route=$_POST['route'];
    $driver=$_POST['driver'];

    mysqli_query($conn,"UPDATE vehicles SET
    vehicle_name='$vehicle',
    route_name='$route',
    driver_name='$driver'
    WHERE id=$id");

    header("Location: vehicles.php");
}
?>

<link rel="stylesheet" href="assets/style.css">

<form class="edit-box" method="post">
<h3>Edit Vehicle</h3>

<select name="vehicle">
<option <?= $data['vehicle_name']=="Bus 1"?"selected":"" ?>>Bus 1</option>
<option <?= $data['vehicle_name']=="Bus 2"?"selected":"" ?>>Bus 2</option>
<option <?= $data['vehicle_name']=="Bus 3"?"selected":"" ?>>Bus 3</option>
<option <?= $data['vehicle_name']=="Van 1"?"selected":"" ?>>Van 1</option>
<option <?= $data['vehicle_name']=="Truck 1"?"selected":"" ?>>Truck 1</option>
</select>

<select name="route">
<option <?= $data['route_name']=="Delhi"?"selected":"" ?>>Delhi</option>
<option <?= $data['route_name']=="Noida"?"selected":"" ?>>Noida</option>
<option <?= $data['route_name']=="Gurgaon"?"selected":"" ?>>Gurgaon</option>
<option <?= $data['route_name']=="Faridabad"?"selected":"" ?>>Faridabad</option>
<option <?= $data['route_name']=="Ghaziabad"?"selected":"" ?>>Ghaziabad</option>
</select>

<input name="driver" value="<?= $data['driver_name'] ?>">

<button name="update" class="btn">Update</button>
</form>
