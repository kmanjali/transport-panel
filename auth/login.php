<?php
session_start();
include "../config/db.php";
$error="";

if(isset($_POST['login'])){
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    $res = mysqli_query($conn,"SELECT * FROM users WHERE mobile='$mobile'");
    $row = mysqli_fetch_assoc($res);

    if($row && password_verify($password,$row['password'])){
        $_SESSION['user'] = $row['name'];
        header("Location: ../dashboard.php");
        exit;
    } else {
        $error = "Invalid Mobile Number or Password";
    }
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="auth-body">

<div class="auth-container">


<div class="logo">
    <img src="../assets/logo.png" alt="Logo">
</div>

<div class="auth-box">
    <h2>Login</h2>

    <form method="post">
        <label>Mobile Number</label>
        <input type="text" name="mobile" placeholder="Enter mobile number" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <button type="submit" name="login">Login</button>

        <?php if($error){ ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
    </form>

    <a href="#" class="forgot">Forgot Password?</a>
</div>


</div>

</body>
</html>
