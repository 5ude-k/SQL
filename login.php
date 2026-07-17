<?php
session_start();

include "connect.php";

$email_error = "";
$password_error = "";
$login_error = "";

if(isset($_POST['user_login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email)){
        $email_error = "Vui lòng nhập email";
    }

    if(empty($password)){
        $password_error = "Vui lòng nhập password";
    }

    if(
        $email_error == "" &&
        $password_error == ""
    ){

        $password = md5($password);

        $sql = "SELECT *
                FROM user
                WHERE email='$email'
                AND password='$password'";

        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){

            $user = mysqli_fetch_assoc($result);

            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            echo "Đăng nhập thành công";

        }else{
            $login_error = "Sai email hoặc password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>LOGIN</h2>

<form method="POST">

    Email:
    <input type="text" name="email">
    <br>
    <span style="color:red">
        <?php echo $email_error; ?>
    </span>
    <br>

    Password:
    <input type="password" name="password">
    <br>
    <span style="color:red">
        <?php echo $password_error; ?>
    </span>
    <br>

    <span style="color:red">
        <?php echo $login_error; ?>
    </span>
    <br>

    <button type="submit" name="user_login">
        Login
    </button>

</form>

</body>
</html>
