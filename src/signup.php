<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

if (isset($_POST["signup"])) {

    $fname = $_POST['Full_Name'];
    $email = $_POST['Email'];
    $age = $_POST['Age'];
    $username = $_POST['UserName'];
    $password = $_POST['Password'];
    $cPassword = $_POST['CPassword'];

    if (!empty($fname) && !empty($email) && !empty($age) && !empty($_POST['Gender']) && !empty($username) && !empty($password) && !empty($cPassword)) {

        $check_username = "SELECT COUNT(*) FROM `User` WHERE `UserName` = '$username'";
        $result = mysqli_query($con, $check_username);
        $row = mysqli_fetch_assoc($result);
        if ($row['COUNT(*)'] > 0) {
            header("Location: signup.php?error=userexists&Full_Name=" . $fname . "&Email=" . $email . "&Age=" . $age . "&Photo=" . $_FILES['Photo']['name']);
            exit();
        } else {

            $gender = $_POST['Gender'];

            if ($password == $cPassword) {

                $password = password_hash($password, PASSWORD_DEFAULT);

                if (!empty($_FILES['Photo']['name'])) {

                    $imagename = $_FILES['Photo']['name'];
                    $tmpname = $_FILES['Photo']['tmp_name'];
                    $error = $_FILES['Photo']['error'];

                    if ($error === 0) {
                        $imageex = pathinfo($imagename, PATHINFO_EXTENSION);

                        $imageexlc = strtolower($imageex);

                        $allowedex = array('jpg', 'jpeg', 'png');

                        if (in_array($imageexlc, $allowedex)) {
                            $newimgname = uniqid("IMG-", true) . '.' . $imageexlc;
                            $imguploadpath = 'uploads/user/' . $newimgname;
                            move_uploaded_file($tmpname, $imguploadpath);
                            $newimgname = 'uploads/user/' . $newimgname;
                        } else {
                            exit();
                        }
                    }
                } else {
                    $newimgname = "uploads/user/default.png";
                }

                $newimgname = mysqli_real_escape_string($con, $newimgname);
                $fname = mysqli_real_escape_string($con, $fname);
                $gender = mysqli_real_escape_string($con, $gender);
                $age = mysqli_real_escape_string($con, $age);
                $email = mysqli_real_escape_string($con, $email);
                $username = mysqli_real_escape_string($con, $username);
                $password = mysqli_real_escape_string($con, $password);


                $insert = "INSERT INTO `User` (`photo`, `fullName`, `gender`, `age`, `email`, `username`, `password`) 
          VALUES (\"$newimgname\", \"$fname\", \"$gender\", \"$age\", \"$email\", \"$username\", \"$password\")";
                $yes = mysqli_query($con, $insert);
                if ($yes) {
                    header("Location: login.php?signup=success");
                    exit();
                } else {
                    header("Location: signup.php?error=failed&Full_Name=" . $fname . "&Email=" . $email . "&Age=" . $age . "&UserName=" . $username . "&Photo=" . $_FILES['Photo']['name']);
                    exit();
                }
            } else {
                header("Location: signup.php?error=nomatch&Full_Name=" . $fname . "&Email=" . $email . "&Age=" . $age . "&UserName=" . $username . "&Photo=" . $_FILES['Photo']['name']);
                exit();
            }
        }
    } else {
        header("Location: signup.php?error=emptyfields&Full_Name=" . $fname . "&Email=" . $email . "&Age=" . $age . "&UserName=" . $username . "&Photo=" . $_FILES['Photo']['name']);
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
    <title>Sign Up</title>
    <style>
        .bg-cover {
            background-image: url('./img/img3.jpeg');
        }
    </style>
</head>

<body class="w-full flex bg-gradient-to-b from-blue-50 to-blue-200">
    <div class="relative w-1/2 h-screen bg-cover">
        <div class="absolute inset-0 bg-black opacity-40 flex items-center justify-center text-white text-3xl"></div>
    </div>
    <div class="w-1/2 my-auto">
        <div class="flex items-center justify-center">
            <img src="./img/logo.png" alt="logo" class="w-16">
            <h1 class="font-serif font-bold text-sky-800 text-3xl">Bright Futures</h1>
        </div>

        <p class="text-xl -mt-1 font-bold text-sky-800 font-serif text-center mx-auto">Join Now</p>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <div class="mt-10 w-[75%] mx-auto">
                <input id="fullName" name="Full_Name" type="text" placeholder="Full Name *" value="<?php if (isset($_GET['Full_Name'])) {
                                                                                                        echo $_GET['Full_Name'];
                                                                                                    } ?>" class="border rounded p-2 w-full" required />
                <input id="email" name="Email" type="text" placeholder="Email *" value="<?php if (isset($_GET['Email'])) {
                                                                                            echo $_GET['Email'];
                                                                                        } ?>" class="border rounded p-2 w-full mt-2" required />
                <input id="username" name="UserName" type="text" placeholder="Username *" value="<?php if (isset($_GET['UserName'])) {
                                                                                                    echo $_GET['UserName'];
                                                                                                } ?>" class="border rounded p-2 w-full mt-2" required />
                <input id="age" name="Age" type="number" placeholder="Age *" value="<?php if (isset($_GET['Age'])) {
                                                                                        echo $_GET['Age'];
                                                                                    } ?>" class="border rounded p-2 w-full mt-2" required />
                <div class="w-full grid grid-cols-5 bg-white mt-2">
                    <div class="col-span-2 md:mb-0 pb-3 pl-2">
                        <label htmlFor="gender" class="text-gray-400">
                            Gender *
                        </label>
                        <div class="border rounded-lg border-gray-400 flex py-1 px-4 mt-1">
                            <input type="radio" name="Gender" value="Male" />
                            Male
                            <input type="radio" name="Gender" value="Female" class="ml-2" />
                            Female
                        </div>
                    </div>
                    <div class="col-span-2 mt-2 ml-6">
                        <label for="Photo" class="text-gray-400">Upload Profile Picture</label>
                        <input type="file" name="Photo" value="<?php if (isset($_GET['Photo'])) {
                                                                    echo $_GET['Photo'];
                                                                } ?>" class="" />
                    </div>
                </div>
                <!-- <input type="text" name="username" placeholder="Username" class="border rounded p-2 w-full" required> -->
                <!-- <input type="email" name="email" placeholder="Email" class="border rounded p-2 w-full mt-4" required> -->
                <div class="relative mt-4">
                    <input type="password" id="password" minLength={8} name="Password" placeholder="Password *" class="border rounded p-2 w-full" required>
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-2">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="relative mt-4">
                    <input type="password" id="confirmPassword" minLength={8} name="CPassword" placeholder="Confirm Password *" class="border rounded p-2 w-full" required>

                    <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 flex items-center px-2">
                        <i class="fas fa-eye" id="confirmEyeIcon"></i>
                    </button>
                    <div class="border rounded w-full">
                    </div>
                </div>
                <div class="text-red-600">
                    <?php

                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyfields") {
                    ?>
                            <div class="error"> <?php echo "Empty Fields!!!" ?></div>
                        <?php
                        } elseif ($_GET['error'] == "nomatch") {
                        ?>
                            <div class="error"><?php echo "Passwords Dont Match!" ?></div>
                        <?php
                        } elseif ($_GET['error'] == "userexists") {
                        ?>
                            <div class="error"><?php echo "User Exists!" ?></div>
                        <?php
                        } elseif ($_GET['error'] == "notsupported") {
                        ?>
                            <div class="error"> <?php echo "Photo not supported!" ?></div>
                        <?php
                        } elseif ($_GET['error'] == "failed") {
                        ?>
                            <div class="error"> <?php echo "Failed to register!" ?></div>
                        <?php
                        } elseif ($_GET['signup'] == "success") {
                        ?>
                            <div class="error"> <?php echo "Succesfully registered!" ?></div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <button type="submit" name="signup" class="bg-blue-500 text-white p-3 rounded-lg w-full mt-4">Sign Up</button>
            </div>
        </form>

        <p class="font-extralight text-center mt-4 w-[75%] mx-auto">
            Already have an account?
            <a href="/Charity/src/login.php" class="text-blue-600 ml-1">Login</a>
        </p>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        });

        // Toggle confirm password visibility
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const confirmEyeIcon = document.getElementById('confirmEyeIcon');
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            confirmEyeIcon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        });

        function handleSubmit(event) {
            // You can handle any client-side validation here if needed
            return true; // Allow the form to submit
        }
    </script>
</body>

</html>