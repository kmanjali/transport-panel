<?php
session_start();
include "config/db.php";

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit;
}


if(isset($_POST['save'])){
    $route = $_POST['route'];
    $pickups = $_POST['pickup'];

    foreach($pickups as $pid){
        mysqli_query($conn,
        "INSERT INTO route_pickup_mapping(route_id,pickup_id) 
         VALUES('$route','$pid')");
    }
}


$routes = mysqli_query($conn,"SELECT * FROM routes");
$pickups = mysqli_query($conn,"SELECT * FROM pickup_points");

$data = mysqli_query($conn,"
SELECT rpm.id, r.route_name, p.pickup_name, rpm.created_on
FROM route_pickup_mapping rpm
LEFT JOIN routes r ON rpm.route_id=r.id
LEFT JOIN pickup_points p ON rpm.pickup_id=p.id
ORDER BY rpm.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Route Pickup Mapping</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="layout">
<?php include "includes/sidebar.php"; ?>
<div class="main">
<?php include "includes/header.php"; ?>

<div class="content">

<h3 class="page-title">Route & Pickup Mapping</h3>

<form method="post" class="filters">

<select name="route" required>
<option value="">Select Route</option>
<?php while($r=mysqli_fetch_assoc($routes)){ ?>
<option value="<?= $r['id'] ?>"><?= $r['route_name'] ?></option>
<?php } ?>
</select>

<select name="pickup[]" class="pickup-select" required>
    <option value="">Select Pickup Point</option>
    <?php while($p=mysqli_fetch_assoc($pickups)){ ?>
        <option value="<?= $p['id'] ?>"><?= $p['pickup_name'] ?></option>
    <?php } ?>
</select>


<button class="btn" name="save">Apply</button>
</form>

<div class="table-box">
<table>
<tr>
<th>S.No</th>
<th>Route</th>
<th>Pickup Point</th>
<th>Created On</th>
<th>Action</th>
</tr>

<?php $i=1; while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?= $i++ ?></td>
<td><?= $row['route_name'] ?></td>
<td><?= $row['pickup_name'] ?></td>
<td><?= date("d M Y",strtotime($row['created_on'])) ?></td>
<td>
<a href="mapping_delete.php?id=<?= $row['id'] ?>" 
class="action delete"
onclick="return confirm('Delete mapping?')">🗑</a>
</td>
</tr>
<?php } ?>
</table>
</div>

</div>
</div>
</div>

</body>
</html>
