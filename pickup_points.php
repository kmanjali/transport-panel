<?php
session_start();
include "config/db.php";

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit;
}


if(isset($_POST['save'])){
    $pickup = $_POST['pickup'];
    if($pickup!=""){
        mysqli_query($conn,"INSERT INTO pickup_points(pickup_name) VALUES('$pickup')");
    }
}

$data = mysqli_query($conn,"SELECT * FROM pickup_points ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Pickup Points</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="layout">
<?php include "includes/sidebar.php"; ?>

<div class="main">
<?php include "includes/header.php"; ?>

<div class="content">

<div class="page-head left">
    <button type="button" class="btn" onclick="openModal()">
        + Add Pickup Point
    </button>
    <h3>Pickup Points</h3>
</div>



<div class="table-box">
<table>
<tr>
<th>S.No</th>
<th>Pickup Point</th>
<th>Created On</th>
<th>Action</th>
</tr>

<?php $i=1; while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?= $i++ ?></td>
<td><?= $row['pickup_name'] ?></td>
<td><?= date("d M Y",strtotime($row['created_on'])) ?></td>
<td>
<a href="pickup_edit.php?id=<?= $row['id'] ?>" class="action edit">✏️</a>
<a href="pickup_delete.php?id=<?= $row['id'] ?>" 
class="action delete"
onclick="return confirm('Delete this pickup point?')">🗑</a>
</td>
</tr>
<?php } ?>
</table>
</div>

</div>
</div>
</div>


<div id="pickupModal" class="modal">
<div class="modal-box">
<h3>Add Pickup Point</h3>

<form method="post">
<input name="pickup" placeholder="Pickup Point Name" required>
<button class="btn" name="save">Save</button>
<button type="button" class="btn light" onclick="closeModal()">Cancel</button>
</form>

</div>
</div>

<script>
function openModal(){
    document.getElementById("pickupModal").style.display = "flex";
    document.body.style.overflow = "hidden";
}

function closeModal(){
    document.getElementById("pickupModal").style.display = "none";
    document.body.style.overflow = "auto";
}
</script>


</body>
</html>
