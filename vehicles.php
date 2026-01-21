<?php
session_start();
include "config/db.php";

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit;
}

/* ---------- FORM SUBMIT ---------- */
if(isset($_POST['apply'])){

    $vehicle = trim($_POST['vehicle']);
    $route   = intval($_POST['route']);
    $driver  = trim($_POST['driver']);

    $imageName = '';

    if(!empty($_FILES['image']['name'])){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = time().'_vehicle.'.$ext;
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "assets/vehicles/".$imageName
        );
    }

    if($vehicle && $route && $driver){
        mysqli_query($conn,"
        INSERT INTO vehicles(vehicle_name,route_id,driver_name,vehicle_image)
        VALUES('$vehicle','$route','$driver','$imageName')
        ");
    }
}

/* ---------- FETCH ROUTES ---------- */
$routes = mysqli_query($conn,"SELECT id, route_name FROM routes");

/* ---------- FETCH VEHICLES FOR DROPDOWN ---------- */
$vehicleList = mysqli_query($conn,"
SELECT id, vehicle_name 
FROM vehicles_master 
ORDER BY vehicle_name
");

/* ---------- FETCH VEHICLE DATA ---------- */
$vehicles = mysqli_query($conn,"
SELECT v.*, r.route_name
FROM vehicles v
LEFT JOIN routes r ON r.id = v.route_id
ORDER BY v.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Vehicles</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="layout">
<?php include "includes/sidebar.php"; ?>

<div class="main">
<?php include "includes/header.php"; ?>

<div class="content">

<h3 class="page-title">Vehicles</h3>

<!-- ================= FORM ================= -->
<form class="filters" method="post" enctype="multipart/form-data">

<select name="vehicle" required>
<option value="">Select Vehicle</option>
<?php while($v=mysqli_fetch_assoc($vehicleList)){ ?>
<option value="<?= $v['vehicle_name'] ?>">
    <?= $v['vehicle_name'] ?>
</option>
<?php } ?>
</select>

<select name="route" required>
<option value="">Select Route</option>
<?php while($r=mysqli_fetch_assoc($routes)){ ?>
<option value="<?= $r['id'] ?>"><?= $r['route_name'] ?></option>
<?php } ?>
</select>

<input type="text" name="driver" placeholder="Driver Name" required>

<input type="file" name="image" accept="image/*">

<button class="btn" name="apply">Apply</button>

</form>

<!-- ================= TABLE ================= -->
<div class="table-box">
<table>
<tr>
<th>#</th>
<th>Vehicle</th>
<th>Route</th>
<th>Driver</th>
<th>Image</th>
<th>Action</th>
</tr>

<?php $i=1; while($row=mysqli_fetch_assoc($vehicles)){ ?>
<tr>
<td><?= $i++ ?></td>
<td><?= $row['vehicle_name'] ?></td>
<td><?= $row['route_name'] ?></td>
<td><?= $row['driver_name'] ?></td>
<td>
<?php if($row['vehicle_image']){ ?>
<img src="assets/vehicles/<?= $row['vehicle_image'] ?>" width="60">
<?php } ?>
</td>
<td>
<a href="vehicle_edit.php?id=<?= $row['id'] ?>" class="action edit">✏️</a>
<a href="vehicle_delete.php?id=<?= $row['id'] ?>"
onclick="return confirm('Delete vehicle?')" class="action delete">🗑</a>
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
