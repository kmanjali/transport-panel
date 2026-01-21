<?php
include "config/db.php";
$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM routes WHERE id=$id");
header("Location: routes.php");
