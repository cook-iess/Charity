<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['Username']) && isset($_COOKIE['Username'])) {

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


    $campaignId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $campaignQuery = "SELECT * FROM Charity WHERE id = $campaignId";
    $campaignResult = mysqli_query($con, $campaignQuery);
    $campaign = mysqli_fetch_assoc($campaignResult);

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

    <body class="bg-gray-100 py-4">

        <div class="grid grid-cols-8 my-auto">
            <div class="col-span-1"></div>
            <div class="col-span-3 my-auto">
                <div class="relative px-4 pl-28 mt-7">
                    <h3 class=" font-bold mb-4 border-2 border-blue-300 bg-blue-100 rounded-lg p-4 text-gray-800"><?php echo htmlspecialchars($campaignDesc); ?></h3>

                    <!-- Image with overlay for the title -->
                    <div class="relative group">
                        <img src="<?php echo $campaignPhoto; ?>" alt="Campaign Image" class="w-full h-auto rounded-lg">
                        <div class="absolute bottom-0 left-0 right-0 bg-blue-500 bg-opacity-50 flex items-center justify-center opacity-100 transition-opacity duration-300 group-hover:opacity-100">
                            <h3 class="font-bold text-white p-2"><?php echo htmlspecialchars($campaignTitle); ?></h3>
                        </div>
                    </div>
                    <div class="text-white pt-4 mt-4 pb-4 bg-blue-500 mr-40 rounded-r-3xl">
                        <h3 class="text-sm px-2 "><span class="font-semibold ">Username</span>: <?php echo $username; ?></h3>
                        <h3 class="text-sm px-2"><span class="font-semibold ">Left Balance</span>: <?php echo $leftBalance; ?> birr</h3>
                    </div>
                </div>
            </div>
            <div class="col-span-3 space-x-14 my-auto">
                <h1 class="text-3xl font-bold mb-6 text-center"><?php echo htmlspecialchars($campaignTitle); ?></h1>
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <form action="process_donation.php" method="POST">
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
                            <input type="text" id="amount" name="amount" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-400" placeholder="Amount" value="<?php echo $amount; ?>">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-400" placeholder="Enter your password">
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="shareContact" class="mr-2">
                                <span class="text-sm text-gray-600">I agree to share my contact information with the campaign organizers.</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="stayAnonymous" class="mr-2">
                                <span class="text-sm text-gray-600">I wish to remain anonymous.</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">Donate</button>
                    </form>
                </div>
            </div>

            <div class="col-span1"></div>
        </div>

    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>