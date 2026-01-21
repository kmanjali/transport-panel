<?php
include "../config/db.php";
$error="";

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    if($name=="" || $mobile=="" || $password==""){
        $error = "All fields required";
    } else {
        $check = mysqli_query($conn,"SELECT * FROM users WHERE mobile='$mobile'");
        if(mysqli_num_rows($check) > 0){
            $error = "Mobile number already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn,"INSERT INTO users(name,mobile,password)
            VALUES('$name','$mobile','$hash')");
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="auth-blue-body">

<div class="auth-container">


<div class="logo white">
    <img src="../assets/logo.png" alt="Logo">
    <span>Logo</span>
</div>

<div class="auth-box">
    <h2>Register</h2>

    <form method="post">
        <label>Name</label>
        <input type="text" name="name" placeholder="Enter name" required>

        <label>Mobile Number</label>
        <input type="text" name="mobile" placeholder="Enter mobile number" required>

        <?php if($error){ ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <button type="submit" name="register">Register</button>
    </form>

    <p class="login-link">
        Already have an account?
        <a href="login.php">Login</a>
    </p>
</div>


</div>

</body>
</html>
