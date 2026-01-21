<?php
include "config/db.php";
$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM vehicles WHERE id=$id");
header("Location: vehicles.php");
