<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['Username']) && isset($_COOKIE['Username'])) {

    $username = $_SESSION['Username'];
    $campaignId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $campaignQuery = "SELECT * FROM Charity WHERE id = $campaignId";
    $campaignResult = mysqli_query($con, $campaignQuery);
    $campaign = mysqli_fetch_assoc($campaignResult);

    if (isset($_POST["donate"])) {

        $username = $_SESSION['Username'];
        $amount = $_POST['amount'];
        $campId = isset($_GET['id']) ? $_GET['id'] : '';
        $password = $_POST['password'];

        if (!empty($amount) && !empty($password) && !empty($campId) && !empty($username)) {
            $id = isset($_GET['id']) ? $_GET['id'] : '';

            $share = $_POST['share'];

            $sql = "SELECT * FROM `User` WHERE `username` = '$username'";
            $rs = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($rs);
            $count = mysqli_num_rows($rs);

            if ($test = password_verify($password, $result['password'])) {

                $newBalance = $result['balance'] - $amount;

                // Update the user's balance in the database
                $updateBalanceQuery = "UPDATE User SET balance = '$newBalance' WHERE username = '$username'";
                mysqli_query($con, $updateBalanceQuery);

                // Update the achieved goal of the charity campaign
                $updateAchieved = $campaign['achievedGoal'] + $amount; // Corrected spelling
                $campaignTitle = $campaign['campTitle'];

                // Update the achieved goal in the Charity table
                $updateAchievedQuery = "UPDATE Charity SET achievedGoal = '$updateAchieved' WHERE id = '$campaignId'";
                mysqli_query($con, $updateAchievedQuery);

                $orgName = htmlspecialchars($campaign['orgName']);

                $notificationMessage = "Thank you for your donation of $amount Birr to $orgName!";
                $notificationQuery = "INSERT INTO Notifications (username, message) VALUES ('$username', '$notificationMessage')";
                mysqli_query($con, $notificationQuery);

                // Add a notification for the organization
                $notificationMessageOrg = "User $username donated $amount Birr for the campaign '$campaignTitle'.";
                $orgNamee = mysqli_real_escape_string($con, $orgName);
                $notificationMessageOrgg = mysqli_real_escape_string($con, $notificationMessageOrg);

                $notificationQueryOrg = "INSERT INTO fNotification (orgName, message) VALUES ('$orgNamee', '$notificationMessageOrgg')";
                mysqli_query($con, $notificationQueryOrg);

                $username = mysqli_real_escape_string($con, $username);
                $amount = mysqli_real_escape_string($con, $amount);
                $campId = mysqli_real_escape_string($con, $campId);
                $share = mysqli_real_escape_string($con, $share);

                // Insert the campaign data into the database
                $insert = "INSERT INTO Donations (username, amount, campId, shareInfo) 
                       VALUES ('$username', '$amount', '$campId', '$share')";

                $resultt = mysqli_query($con, $insert);

                if ($resultt) {
                    header("Location: projects.php?submission=success");
                    exit();
                } else {
                    header("Location: donate.php?error=failed");
                    exit();
                }
            } else {
                header("Location: donate.php?error=incorrect&id=" . $campId . "&amount=" . $amount);
                exit();
            }
        } else {
            header("Location: donate.php?error=emptyfields&id=" . $campId . "&amount=" . $amount);
            exit();
        }
    }

    $userId = $_SESSION['Username'];
    $amount = isset($_GET['amount']) ? $_GET['amount'] : '';

    // Fetch user data
    $userQuery = "SELECT * FROM User WHERE username = '$userId'";
    $userResult = mysqli_query($con, $userQuery);
    $user = mysqli_fetch_assoc($userResult);

    if ($user) {
        $username = htmlspecialchars($_SESSION['Username']);
        $leftBalance = htmlspecialchars($user['balance']);
        $fullname = htmlspecialchars($user['fullName']);
        $email = htmlspecialchars($user['email']);
    }

    if ($campaign) {
        $campaignTitle = $campaign['campTitle'];
        $campaignDesc = $campaign['campDesc'];
        // Split the comma-separated string into an array
        $photoPaths = explode(',', $campaign['photo_paths']);

        // Get the first photo path
        $campaignPhoto = htmlspecialchars(trim($photoPaths[0])); // Use trim to remove any extra spaces
    } else {
        die("Campaign not found.");
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Donate to <?php echo htmlspecialchars($campaignTitle); ?></title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100 md:py-4">

        <div class="grid md:grid-cols-8 my-auto">
            <div class="col-span-1"></div>
            <div class="col-span-3 my-auto">
                <div class="relative px-4 md:pl-28 mt-7">
                    <h3 class=" font-bold mb-4 border-2 border-blue-300 bg-blue-100 rounded-lg p-4 text-gray-800"><?php echo htmlspecialchars($campaignDesc); ?></h3>

                    <!-- Image with overlay for the title -->
                    <div class="relative group">
                        <img src="<?php echo $campaignPhoto; ?>" alt="Campaign Image" class="w-full h-auto rounded-lg">
                        <div class="absolute bottom-0 left-0 right-0 bg-blue-500 bg-opacity-50 flex items-center justify-center opacity-100 transition-opacity duration-300 group-hover:opacity-100">
                            <h3 class="font-bold text-white p-2"><?php echo htmlspecialchars($campaignTitle); ?></h3>
                        </div>
                    </div>
                    <div class="text-white pt-4 mt-4 pb-4 md:mb-0 mb-4 bg-blue-500 mr-40 rounded-r-3xl">
                        <h3 class="md:text-sm text-xs px-2 "><span class="font-semibold ">Username</span>: <?php echo $username; ?></h3>
                        <h3 class="md:text-sm text-xs px-2"><span class="font-semibold ">Left Balance</span>: <?php echo $leftBalance; ?> birr</h3>
                    </div>
                </div>
            </div>
            <div class="col-span-3 md:space-x-14 my-auto">
                <h1 class="text-3xl font-bold mb-6 text-center"><?php echo htmlspecialchars($campaignTitle); ?></h1>
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $campaignId; ?>&amount=<?php echo $amount; ?>" method="POST">
                        <div class="mb-4">
                            <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="fullName" name="fullName" readonly value="<?php echo $fullname ?>" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-400" placeholder="John Doe">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" readonly value="<?php echo $email ?>" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-400" placeholder="john@example.com">
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Amount</label>
                            <input type="number" id="amount" name="amount" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-400" placeholder="Amount" value="<?php echo $amount; ?>">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-400" placeholder="Enter your password">
                        </div>

                        <div class="mb-2">
                            <div class="py-2 text-gray-600 mt-1">
                                <input type="radio" name="share" value="1" />
                                I agree to share my contact information with the campaign organizers.
                                <br>
                                <input type="radio" name="share" value="0" />
                                I wish to remain anonymous.
                            </div>
                        </div>

                        <div class="mt-1 mb-2 text-red-600 pl-1">
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

                        <button type="submit" name="donate" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">Donate</button>
                    </form>
                </div>
            </div>

            <div class="col-span1"></div>
        </div>

        <script>
            console.log("<?php echo $campaignId; ?>")
        </script>

    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>