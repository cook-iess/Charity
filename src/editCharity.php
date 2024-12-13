<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conn.php");
session_start();

if (isset($_SESSION['orgName']) && isset($_COOKIE['orgName'])) {

    $orgName = $_SESSION['orgName'];
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $sql2 = "SELECT * FROM `Charity` WHERE `orgName` = '$orgName' AND `id` = '$id'";
    $rs2 = mysqli_query($con, $sql2);
    $resultt = mysqli_fetch_assoc($rs2);

    if (isset($_POST['update'])) {

        $campDesc = $_POST['campDesc'];
        $targetGoal = $_POST['targetGoal'];
        $challenges = $_POST['challenges'];
        $solutions = $_POST['solutions'];
        $password = $_POST['Password'];

        if (!empty($campDesc) && !empty($targetGoal) && !empty($_POST['challenges']) && !empty($solutions)) {

            $sql = "SELECT * FROM `Organization` WHERE `orgName` = '$orgName'";
            $rs = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($rs);
            if (password_verify($password, $result['password'])) {

                $campDesc = mysqli_real_escape_string($con, $campDesc);
                $targetGoal = mysqli_real_escape_string($con, $targetGoal);
                $challenges = mysqli_real_escape_string($con, $challenges);
                $solutions = mysqli_real_escape_string($con, $solutions);

                $sql = "UPDATE Charity SET campDesc = '$campDesc', targetGoal = '$targetGoal', challenges = '$challenges', solutions = '$solutions' WHERE orgName = '$orgName'";
                if ($con->query($sql) === TRUE) {
                    header("Location: findex.php?update=success");
                    exit();
                } else {
                    header("Location: editCharity.php?update=notsuccess");
                    exit();
                }
            } else {
                header("Location: editCharity.php?error=incorrect");
                exit();
            }
        } else {
            header("Location: editCharity.php?error=emptyfields");
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
        <title>Edit Charity Campaign</title>
    </head>

    <body class="flex my-16 bg-gradient-to-b from-white to-blue-100">
        <div class="w-full max-w-2xl m-auto p-8 bg-white rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold text-center text-sky-800 mb-6">Edit Campaign</h1>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="campaignTitle" class="block text-sm font-medium text-gray-700">Campaign Title *</label>
                    <input type="text" id="campaignTitle" name="campaignTitle" placeholder="Enter campaign title" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" required value="<?php echo $resultt['campTitle'] ?>" readonly/>
                </div>
                <div class="mb-4">
                    <label for="campaignDesc" class="block text-sm font-medium text-gray-700">Campaign Description *</label>
                    <textarea id="campaignDesc" name="campDesc" rows="4" placeholder="Describe your campaign" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" required><?php echo $resultt['campDesc'] ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="orgName" class="block text-sm font-medium text-gray-700">Organization Name *</label>
                    <input type="text" id="orgName" name="orgName" placeholder="Enter organization name" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" required required value="<?php echo $resultt['orgName'] ?>" readonly />
                </div>
                <div class="mb-4">
                    <label for="targetGoal" class="block text-sm font-medium text-gray-700">Target Goal (Birr) *</label>
                    <input type="number" id="targetGoal" name="targetGoal" placeholder="Enter target goal" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" required value="<?php echo $resultt['targetGoal'] ?>" />
                </div>
                <div class="mb-4">
                    <label for="challenges" class="block text-sm font-medium text-gray-700">Challenges Faced *</label>
                    <textarea id="challenges" name="challenges" rows="4" placeholder="What challenges are you facing?" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300"><?php echo $resultt['challenges'] ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="solutions" class="block text-sm font-medium text-gray-700">Proposed Solutions *</label>
                    <textarea id="solutions" name="solutions" rows="4" placeholder="What solutions do you propose?" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300"><?php echo $resultt['solutions'] ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="Password" class="block text-sm font-medium text-gray-700">Enter Your Password</label>
                    <input type="password" id="Password" name="Password" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" />
                </div>
                <div class="mb-4 text-red-600">
                    <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyfields") {
                            echo "Please fill in all fields!";
                        } elseif ($_GET['error'] == "imageupload") {
                    ?>
                            <div class="error text-red"> <?php echo "Upload Image/s!"; ?></div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <button type="submit" name="update" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200">Update Campaign</button>
            </form>
        </div>
    </body>

    </html>

<?php

} else {
    header("Location: flogin.php");
}
?>