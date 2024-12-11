<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

if (isset($_POST["signup"])) {

    $orgName = $_POST['orgName'];
    $orgDesc = $_POST['orgDesc'];
    $location = $_POST['location'];
    $website = $_POST['website'];
    $password = $_POST['Password'];
    $cPassword = $_POST['CPassword'];

    if (!empty($orgName) && !empty($orgDesc) && !empty($location) && !empty($_POST['website']) && !empty($password) && !empty($cPassword)) {

        if (isset($_POST["Agree"])) {
            $check_orgName = "SELECT COUNT(*) FROM `Organization` WHERE `orgName` = '$orgName'";
            $result = mysqli_query($con, $check_orgName);
            $row = mysqli_fetch_assoc($result);
            if ($row['COUNT(*)'] > 0) {
                header("Location: fSignup.php?error=userexists&orgName=" . $orgName . "&orgDesc=" . $orgDesc . "&location=" . $location . "&website=" . $website);
                exit();
            } else {

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
                                $imguploadpath = 'uploads/org/' . $newimgname;
                                move_uploaded_file($tmpname, $imguploadpath);
                                $newimgname = 'uploads/org/' . $newimgname;
                            } else {
                                exit();
                            }
                        }
                    } else {
                        header("Location: fSignup.php?error=mustpp&orgName=" . $orgName . "&orgDesc=" . $orgDesc . "&location=" . $location . "&website=" . $website);
                        exit();
                    }

                    $newimgname = mysqli_real_escape_string($con, $newimgname);
                    $orgName = mysqli_real_escape_string($con, $orgName);
                    $orgDesc = mysqli_real_escape_string($con, $orgDesc);
                    $location = mysqli_real_escape_string($con, $location);
                    $website = mysqli_real_escape_string($con, $website);
                    $ceo = mysqli_real_escape_string($con, $ceo);
                    $password = mysqli_real_escape_string($con, $password);


                    $insert = "INSERT INTO `Organization` (`logo`, `orgName`, `orgDesc`, `location`, `website`, `password`) 
          VALUES (\"$newimgname\", \"$orgName\", \"$orgDesc\", \"$location\", \"$website\", \"$password\")";
                    $yes = mysqli_query($con, $insert);
                    if ($yes) {
                        header("Location: fLogin.php?signup=success");
                        exit();
                    } else {
                        header("Location: fSignup.php?error=failed&orgName=" . $orgName . "&orgDesc=" . $orgDesc . "&location=" . $location . "&website=" . $website);
                        exit();
                    }
                } else {
                    header("Location: fSignup.php?error=nomatch&orgName=" . $orgName . "&orgDesc=" . $orgDesc . "&location=" . $location . "&website=" . $website);
                    exit();
                }
            }
        } else {
            header("Location: fSignup.php?error=notaggreed&orgName=" . $orgName . "&orgDesc=" . $orgDesc . "&location=" . $location . "&website=" . $website);
            exit();
        }
    } else {
        header("Location: fSignup.php?error=emptyfields&orgName=" . $orgName . "&orgDesc=" . $orgDesc . "&location=" . $location . "&website=" . $website);
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
    <title>Fundraiser Signup</title>
    <style>
        .bg-cover {
            background-image: url('./img/img2.jpg');
        }
    </style>
</head>

<body class="w-full flex bg-gradient-to-b from-blue-50 to-blue-200">
    <div class="relative w-1/4 h-screen bg-cover bg-center">
        <div class="absolute inset-0 bg-black opacity-40 flex items-center justify-center text-white text-3xl"></div>
    </div>
    <div class="w-3/4 my-auto">
        <div class="flex items-center justify-center">
            <img src="./img/logo.png" alt="logo" class="w-16">
            <h1 class="font-serif font-bold text-sky-800 text-3xl">Bright Futures</h1>
        </div>

        <p class="text-xl -mt-1 font-bold text-sky-800 font-serif text-center mx-auto">Join As a Fundraiser NGO</p>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <div class="mt-4 w-[75%] mx-auto">
                <input id="orgNmae" name="orgName" type="text" placeholder="Orgnization Name*" value="<?php if (isset($_GET['orgName'])) {
                                                                                                            echo $_GET['orgName'];
                                                                                                        } ?>" class="border rounded p-2 w-full" required />
                <textarea id="orgDesc" name="orgDesc" type="text" placeholder="Orginazation Description *" value="<?php if (isset($_GET['orgDesc'])) {
                                                                                                                        echo $_GET['orgDesc'];
                                                                                                                    } ?>" class="border rounded p-2 w-full mt-2" required></textarea>
                <div class="mt-3 border rounded bg-white py-2 pl-2">
                    <label for="Photo" class="text-gray-400">Upload Logo * </label>
                    <input type="file" name="Photo" value="<?php if (isset($_GET['Photo'])) {
                                                                echo $_GET['Photo'];
                                                            } ?>" class="" />
                </div>
                <div class="w-full grid grid-cols-4 mt-2 gap-x-2">
                    <div class="col-span-2 md:mb-0 my-auto mt-2">
                        <select id="organizationType" name="organizationType" class="text-gray-500 w-full border border-gray-300 rounded-lg p-2 focus:outline-none ">
                            <option value="" disabled selected hidden class="text-gray-700">Choose Organization Type</option>
                            <option value="NGO" class="text-black">NGO</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <input id="website" name="website" type="text" placeholder="Website *" value="<?php if (isset($_GET['Website'])) {
                                                                                                            echo $_GET['Website'];
                                                                                                        } ?>" class="border rounded p-2 mt-2 w-full" required />
                    </div>
                </div>
                <input id="location" name="location" type="text" placeholder="Country, City/State, Street *" value="<?php if (isset($_GET['location'])) {
                                                                                                                        echo $_GET['location'];
                                                                                                                    } ?>" class="border rounded p-2 w-full mt-4" required />
                <!-- <input type="text" name="username" placeholder="Username" class="border rounded p-2 w-full" required> -->
                <!-- <input type="email" name="email" placeholder="Email" class="border rounded p-2 w-full mt-4" required> -->
                <div class="w-full grid grid-cols-2 mt-1 gap-x-2">
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
                </div>
                <div class="mt-2 mx-auto text-gray-700 w-3/4 text-center">
                    <input type="checkbox" name="Agree" class="border" />
                    <p class="inline"> I confirm that all the information I have provided is accurate and truthful, and I understand that I am responsible for any discrepancies. </p>
                </div>
                <div class="text-red-600">
                    <?php

                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyfields") {
                    ?>
                            <div class="error"> <?php echo "Empty Fields!!!" ?></div>
                        <?php
                        } elseif ($_GET['error'] == "notaggreed") {
                        ?>
                            <div class="error text-red"> <?php echo "Check the Box!"; ?></div>
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
                <button type="submit" name="signup" class="bg-blue-500 text-white p-3 rounded-lg w-full mt-4">Register</button>
            </div>
        </form>

        <p class="font-extralight text-center mt-4 w-[75%] mx-auto">
            Already registered?
            <a href="/Charity/src/fLogin.php" class="text-blue-600 ml-1">Login</a>
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