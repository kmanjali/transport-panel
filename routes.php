<?php
session_start();
include "config/db.php";

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit;
}


if(isset($_POST['save'])){
    $route = $_POST['route'];
    if($route!=""){
        mysqli_query($conn,"INSERT INTO routes(route_name) VALUES('$route')");
    }
}

$data = mysqli_query($conn,"SELECT * FROM routes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Routes</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="layout">
<?php include "includes/sidebar.php"; ?>

<div class="main">
<?php include "includes/header.php"; ?>

<div class="content">

<div class="page-head">
<h3>Routes</h3>
<button class="btn" onclick="openModal()">+ Add Route</button>
</div>


<div class="table-box">
<table>
<tr>
<th>S.No</th>
<th>Route Name</th>
<th>Created On</th>
<th>Action</th>
</tr>

<?php $i=1; while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?= $i++ ?></td>
<td><?= $row['route_name'] ?></td>
<td><?= date("d M Y",strtotime($row['created_on'])) ?></td>
<td>
<a href="route_edit.php?id=<?= $row['id'] ?>" class="action edit">✏️</a>
<a href="route_delete.php?id=<?= $row['id'] ?>" 
class="action delete"
onclick="return confirm('Delete this route?')">🗑</a>
</td>
</tr>
<?php } ?>
</table>
</div>

</div>
</div>
</div>


<div id="routeModal" class="modal">
<div class="modal-box">
<h3>Add Route</h3>

<form method="post">
<input name="route" placeholder="Route Name" required>
<button class="btn" name="save">Save</button>
<button type="button" class="btn light" onclick="closeModal()">Cancel</button>
</form>

</div>
</div>

<script>
function openModal(){
    document.getElementById("routeModal").style.display="flex";
}
function closeModal(){
    document.getElementById("routeModal").style.display="none";
}
</script>

</body>
</html>
