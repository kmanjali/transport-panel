<?php
session_start();
include "config/db.php";

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit;
}


$where = "1";

if(!empty($_GET['vehicle'])){
    $vehicles = implode("','", $_GET['vehicle']);
    $where .= " AND v.vehicle_name IN ('$vehicles')";
}

if(!empty($_GET['route'])){
    $routes = implode(",", $_GET['route']);
    $where .= " AND r.id IN ($routes)";
}

if(!empty($_GET['driver'])){
    $where .= " AND v.driver_name LIKE '%".$_GET['driver']."%'";
}


$vehicleList = mysqli_query($conn,"SELECT DISTINCT vehicle_name FROM vehicles");


$routeList = mysqli_query($conn,"SELECT * FROM routes");


$data = mysqli_query($conn,"
SELECT 
    v.vehicle_name,
    r.route_name,
    GROUP_CONCAT(p.pickup_name SEPARATOR ', ') AS pickups,
    v.driver_name
FROM vehicles v
LEFT JOIN routes r ON v.route_id = r.id
LEFT JOIN route_pickup_mapping rpm ON r.id = rpm.route_id
LEFT JOIN pickup_points p ON rpm.pickup_id = p.id
WHERE $where
GROUP BY v.id
ORDER BY v.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
<title>Reports</title>
</head>
<body>

<div class="layout">
<?php include "includes/sidebar.php"; ?>
<div class="main">
<?php include "includes/header.php"; ?>

<div class="content">

<h3 class="page-title">Reports</h3>


<form class="filters" method="get">

<select name="vehicle">
<option value="">Vehicle Name</option>
<?php while($v=mysqli_fetch_assoc($vehicleList)){ ?>
<option value="<?= $v['vehicle_name'] ?>"
<?php if(isset($_GET['vehicle']) && $_GET['vehicle']==$v['vehicle_name']) echo "selected"; ?>>
<?= $v['vehicle_name'] ?>
</option>
<?php } ?>
</select>

<select name="route">
<option value="">Routes</option>
<?php while($r=mysqli_fetch_assoc($routeList)){ ?>
<option value="<?= $r['id'] ?>"
<?php if(isset($_GET['route']) && $_GET['route']==$r['id']) echo "selected"; ?>>
<?= $r['route_name'] ?>
</option>
<?php } ?>
</select>

<input type="text" name="driver"
value="<?= $_GET['driver'] ?? '' ?>"
placeholder="Driver Name">

<button class="btn">Apply</button>

</form>




<div class="table-box">
<table>
<tr>
<th>S.No</th>
<th>Vehicle Name</th>
<th>Routes</th>
<th>Pickup Points</th>
<th>Driver Name</th>
</tr>

<?php $i=1; while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?= $i++ ?></td>
<td><?= $row['vehicle_name'] ?></td>
<td><span class="badge blue"><?= $row['route_name'] ?></span></td>
<td><?= $row['pickups'] ?></td>
<td><?= $row['driver_name'] ?></td>
</tr>
<?php } ?>

<?php if(mysqli_num_rows($data)==0){ ?>
<tr>
<td colspan="5" style="text-align:center;">No records found</td>
</tr>
<?php } ?>

</table>
</div>

</div>
</div>
</div>

</body>
</html>
