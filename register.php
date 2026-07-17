<?php
include "connect.php";

$email_error = "";
$password_error = "";
$name_error = "";
$avatar_error = "";

if(isset($_POST['user_register'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    if(empty($email)){
        $email_error = "Vui lòng nhập email";
    }

    if(empty($password)){
        $password_error = "Vui lòng nhập password";
    }

    if(empty($name)){
        $name_error = "Vui lòng nhập name";
    }

    if(empty($_FILES['avatar']['name'])){
        $avatar_error = "Vui lòng chọn ảnh";
    }

    if(
        $email_error == "" &&
        $password_error == "" &&
        $name_error == "" &&
        $avatar_error == ""
    ){

        $file_name = $_FILES['avatar']['name'];
        $file_size = $_FILES['avatar']['size'];

        $ext = strtolower(
            pathinfo($file_name, PATHINFO_EXTENSION)
        );

        $allow = array("jpg","jpeg","png","gif","webp");

        if(!in_array($ext,$allow)){
            $avatar_error = "Chỉ cho phép file ảnh";
        }

        if($file_size > 1024 * 1024){
            $avatar_error = "Ảnh phải nhỏ hơn 1MB";
        }

        if($avatar_error == ""){

            move_uploaded_file(
                $_FILES['avatar']['tmp_name'],
                "uploads/".$file_name
            );

            $password = md5($password);

            $sql = "INSERT INTO user
                    (email,password,name,avatar)
                    VALUES
                    (
                    '$email',
                    '$password',
                    '$name',
                    '$file_name'
                    )";

            mysqli_query($conn,$sql);

            echo "Đăng ký thành công";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>REGISTER</h2>

<form method="POST" enctype="multipart/form-data">

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

    Name:
    <input type="text" name="name">
    <br>
    <span style="color:red">
        <?php echo $name_error; ?>
    </span>
    <br>

    Avatar:
    <input type="file" name="avatar">
    <br>
    <span style="color:red">
        <?php echo $avatar_error; ?>
    </span>
    <br>

    <button type="submit" name="user_register">
        Register
    </button>

</form>

</body>
</html>
