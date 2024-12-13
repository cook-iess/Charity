<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

if (isset($_POST["submit"])) {

    $campaignTitle = $_POST['campaignTitle'];
    $campaignDesc = $_POST['campaignDesc'];
    $organizationId = $_POST['orgName'];
    $targetGoal = $_POST['targetGoal'];
    $challenges = $_POST['challenges'];
    $solutions = $_POST['solutions'];

    if (!empty($campaignTitle) && !empty($campaignDesc) && !empty($organizationId) && !empty($targetGoal) && !empty($challenges) && !empty($solutions)) {

        $photoPaths = [];

        // Handle multiple photo uploads
        if (!empty($_FILES['photos']['name'][0])) {
            foreach ($_FILES['photos']['name'] as $key => $imageName) {
                $tmpName = $_FILES['photos']['tmp_name'][$key];
                $error = $_FILES['photos']['error'][$key];

                if ($error === 0) {
                    $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
                    $imageExtLower = strtolower($imageExt);
                    $allowedExtensions = ['jpg', 'jpeg', 'png'];

                    if (in_array($imageExtLower, $allowedExtensions)) {
                        $newImageName = uniqid("IMG-", true) . '.' . $imageExtLower;
                        $imgUploadPath = 'uploads/campaigns/' . $newImageName;

                        if (move_uploaded_file($tmpName, $imgUploadPath)) {
                            $photoPaths[] = $imgUploadPath;
                        }
                    }
                }
            }
        } else {
            header("Location: postCharity.php?error=imageupload");
            exit();
        }

        $photoPathsString = implode(',', $photoPaths);

        $campaignTitle = mysqli_real_escape_string($con, $campaignTitle);
        $campaignDesc = mysqli_real_escape_string($con, $campaignDesc);
        $organizationId = mysqli_real_escape_string($con, $organizationId);
        $targetGoal = mysqli_real_escape_string($con, $targetGoal);
        $challenges = mysqli_real_escape_string($con, $challenges);
        $solutions = mysqli_real_escape_string($con, $solutions);
        $photoPathsString = mysqli_real_escape_string($con, $photoPathsString);

        // Insert the campaign data into the database
        $insert = "INSERT INTO Charity (campTitle, campDesc, orgName, targetGoal, challenges, solutions, photo_paths) 
                   VALUES ('$campaignTitle', '$campaignDesc', '$organizationId', '$targetGoal', '$challenges', '$solutions', '$photoPathsString')";

        $result = mysqli_query($con, $insert);

        if ($result) {
            header("Location: findex.php?submission=success");
            exit();
        } else {
            header("Location: postCharity.php?error=failed");
            exit();
        }
    } else {
        header("Location: postCharity.php?error=emptyfields");
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
    <title>Post Charity Campaign</title>
</head>

<body class="flex my-16 bg-gradient-to-b from-white to-blue-100">
    <div class="w-full max-w-2xl m-auto p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center text-sky-800 mb-6">Post a Charity Campaign</h1>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="campaignTitle" class="block text-sm font-medium text-gray-700">Campaign Title *</label>
                <input type="text" id="campaignTitle" name="campaignTitle" placeholder="Enter campaign title" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" required />
            </div>
            <div class="mb-4">
                <label for="campaignDesc" class="block text-sm font-medium text-gray-700">Campaign Description *</label>
                <textarea id="campaignDesc" name="campaignDesc" rows="4" placeholder="Describe your campaign" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" required></textarea>
            </div>
            <div class="mb-4">
                <label for="orgName" class="block text-sm font-medium text-gray-700">Organization Name *</label>
                <input type="text" id="orgName" name="orgName" placeholder="Enter organization name" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" required required value="<?php
                                                                                                                                            if (isset($_GET['orgName'])) {
                                                                                                                                                echo $_GET['orgName'];
                                                                                                                                            } ?>" readonly/>
            </div>
            <div class="mb-4">
                <label for="targetGoal" class="block text-sm font-medium text-gray-700">Target Goal (Birr) *</label>
                <input type="number" id="targetGoal" name="targetGoal" placeholder="Enter target goal" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" required />
            </div>
            <div class="mb-4">
                <label for="challenges" class="block text-sm font-medium text-gray-700">Challenges Faced *</label>
                <textarea id="challenges" name="challenges" rows="4" placeholder="What challenges are you facing?" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300"></textarea>
            </div>
            <div class="mb-4">
                <label for="solutions" class="block text-sm font-medium text-gray-700">Proposed Solutions *</label>
                <textarea id="solutions" name="solutions" rows="4" placeholder="What solutions do you propose?" class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300"></textarea>
            </div>
            <div class="mb-4">
                <label for="photos" class="block text-sm font-medium text-gray-700">Upload Photos *</label>
                <input type="file" id="photos" name="photos[]" accept="image/*" multiple class="mt-1 border rounded-md p-2 w-full focus:ring focus:ring-blue-300" />
                <p class="text-gray-500 text-sm mt-1">You can upload multiple images (JPEG, PNG, GIF).</p>
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
            <button type="submit" name="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200">Submit Campaign</button>
        </form>
    </div>
</body>

</html>