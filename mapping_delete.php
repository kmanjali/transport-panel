<?php
include "config/db.php";
$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM route_pickup_mapping WHERE id=$id");
header("Location: route_pickup_mapping.php");
