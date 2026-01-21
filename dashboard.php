<?php
session_start();
include "config/db.php";

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit;
}

$vehicleCount = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM vehicles"));
$routeCount   = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM routes"));
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="layout">

<?php include "includes/sidebar.php"; ?>

<div class="main">

<?php include "includes/header.php"; ?>

<div class="content">



<div class="card-row">

<div class="card blue">
<div>
<h4>Vehicle Count</h4>
<h2><?= $vehicleCount ?></h2>
</div>
<span class="card-icon">🚗</span>
</div>

<div class="card green">
<div>
<h4>Route Count</h4>
<h2><?= $routeCount ?></h2>
</div>
<span class="card-icon">🛣️</span>
</div>

</div>

</div>
</div>
</div>

</body>
</html>
