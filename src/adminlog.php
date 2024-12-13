<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

if (isset($_POST["login"])) {
    $username = $_POST['UserName'];
    $password = $_POST['Password'];

    $usernameAdmin = "Admin321";

    if (!empty($username) && !empty($password)) {

        if ($username == $usernameAdmin) {
            $sql = "SELECT * FROM `User` WHERE `username` = '$username'";
            $rs = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($rs);
            if ($password = 'Admin321') {

                session_start();
                $_SESSION['Username'] = 'Admin';
                setcookie('Username', $username, time() + 3600);

                header("Location: adminHome.php?&login=success");
                exit();
            }
        } else {
            header("Location: login.php?error=signup");
            exit();
        }
    } else {
        header("Location: login.php?error=emptyfields&username=" . $username);
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./output.css">
    <title>Login</title>
    <style>
        .bg-cover {
            background-image: url('./img/img5.jpg');
        }
    </style>
</head>

<body class="w-full flex bg-gradient-to-b from-blue-50 to-blue-200">
    <div class="w-1/2 my-auto">
        <div class="flex items-center justify-center">
            <img src="./img/logo.png" alt="logo" class="w-16">
            <h1 class="font-serif font-bold text-sky-800 text-3xl">Bright Futures</h1>
        </div>

        <p class="text-xl -mt-1 font-bold text-sky-800 font-serif text-center">Admin Login</p>
        <div class="mt-10 w-[70%] mx-auto">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="text" id="Username" name="UserName" placeholder="Username *" class="border rounded p-2 w-full" required value="<?php
                                                                                                                                            if (isset($_GET['username'])) {
                                                                                                                                                echo $_GET['username'];
                                                                                                                                            } ?>" />
                <div class="relative mt-4">
                    <input type="password" id="password" name="Password" minlength="8" placeholder="Password *" class="border rounded p-2 w-full" required>
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-2">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="mt-4 text-red-600 pl-1">
                    <?php

                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyfields") {
                    ?>
                            <div class="error"><?php echo "Empty Feilds!!!"; ?></div>
                        <?php
                        } elseif ($_GET['error'] == "incorrect") {
                        ?>
                            <div class="error"><?php echo "Incorrect combination!"; ?></div>
                        <?php
                        } elseif ($_GET['error'] == "signup") {
                        ?>
                            <div class="error"><?php echo "Signup First"; ?></div>
                        <?php
                        } elseif ($_GET['login'] == "success") {
                        ?>
                            <div class="error"><?php echo "Successfully logged in!"; ?></div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <input value="Login" type="submit" name="login" class="bg-blue-500 text-white p-3 rounded-lg w-full mt-4">
            </form>
        </div>
    </div>
    <div class="relative w-1/2 h-screen bg-cover">
        <div class="absolute inset-0 bg-black opacity-10 flex items-center justify-center text-white text-3xl"></div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    </script>
</body>

</html>