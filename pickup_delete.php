<?php
include "config/db.php";
$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM pickup_points WHERE id=$id");
header("Location: pickup_points.php");
