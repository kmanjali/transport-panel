<?php
session_start();
include "config/db.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit;
}

if(isset($_POST['apply'])){

    $vehicle_name = trim($_POST['vehicle_name']);
    $route_id     = intval($_POST['route']);
    $driver       = trim($_POST['driver']);

    if($vehicle_name && $route_id && $driver){

    
        $check = mysqli_query($conn,
        "SELECT id FROM vehicles_master WHERE vehicle_name='$vehicle_name'");

        if(mysqli_num_rows($check)>0){
            $v = mysqli_fetch_assoc($check);
            $vehicle_id = $v['id'];
        }else{
            mysqli_query($conn,
            "INSERT INTO vehicles_master(vehicle_name)
             VALUES('$vehicle_name')");
            $vehicle_id = mysqli_insert_id($conn);
        }

    
        mysqli_query($conn,
        "INSERT INTO vehicle_route_map(vehicle_id,route_id,driver_name)
         VALUES('$vehicle_id','$route_id','$driver')");
    }
}


$routes = mysqli_query($conn,"SELECT id,route_name FROM routes");


$data = mysqli_query($conn,"
SELECT m.id, m.driver_name, m.created_on,
       v.vehicle_name,
       r.route_name
FROM vehicle_route_map m
JOIN vehicles_master v ON v.id=m.vehicle_id
JOIN routes r ON r.id=m.route_id
ORDER BY m.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="layout">
<?php include "includes/sidebar.php"; ?>
<div class="main">
<?php include "includes/header.php"; ?>

<div class="content">
<h3 class="page-title">Vehicle Route Mapping</h3>

<form method="post" class="filters">

<input type="text" name="vehicle_name"
placeholder="Enter Vehicle Name" required>

<select name="route" required>
<option value="">Select Route</option>
<?php while($r=mysqli_fetch_assoc($routes)){ ?>
<option value="<?= $r['id'] ?>"><?= $r['route_name'] ?></option>
<?php } ?>
</select>

<input type="text" name="driver"
placeholder="Driver Name" required>

<button class="btn" name="apply">Apply</button>
</form>

<div class="table-box">
<table>
<tr>
<th>#</th>
<th>Vehicle</th>
<th>Route</th>
<th>Driver</th>
</tr>

<?php $i=1; while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?= $i++ ?></td>
<td><?= $row['vehicle_name'] ?></td>
<td><?= $row['route_name'] ?></td>
<td><?= $row['driver_name'] ?></td>
</tr>
<?php } ?>
</table>
</div>

</div>
</div>
</div>
</body>
</html>
