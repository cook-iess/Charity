<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

$campaignId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the campaign details
$campaignQuery = "SELECT * FROM Charity WHERE id = $campaignId";
$campaignResult = mysqli_query($con, $campaignQuery);
$campaign = mysqli_fetch_assoc($campaignResult);

// Ensure the campaign was found before proceeding
if ($campaign) {
    $organizationName = mysqli_real_escape_string($con, $campaign['orgName']);
    $orgQuery = "SELECT * FROM Organization WHERE orgName = '$organizationName'";
    $orgResult = mysqli_query($con, $orgQuery);
    $organization = mysqli_fetch_assoc($orgResult);
} else {
    echo "Campaign not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($campaign['campTitle']); ?> - Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .carousel img {
            max-height: 400px;
            object-fit: cover;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
</head>

<body class="bg-gray-100 py-10">

    <div class="container mx-auto md:flex">
        <!-- Main Content -->
        <div class="md:w-3/4 p-4 overflow-auto">
            <div class="">
                <h1 class="md:text-5xl text-xl font-bold mb-6 text-center bg-blue-600 rounded-xl text-white md:py-4"><?php echo htmlspecialchars($campaign['campTitle']); ?></h1>
            </div>

            <!-- Carousel Section -->
            <div class="carousel owl-carousel mb-6">
                <?php
                $photoPaths = explode(',', $campaign['photo_paths']);
                foreach ($photoPaths as $photo): ?>
                    <div class="item">
                        <img src="<?php echo htmlspecialchars($photo); ?>" alt="Campaign Image" class="w-full rounded-lg">
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Campaign Details -->
            <div class="bg-white rounded-lg shadow-lg p-10 mb-6">
                <p class="text-sm text-gray-500 mb-2">
                    Posted at: <?php echo $campaign['created_at']; ?>
                </p>
                <h2 class="md:text-3xl text-xl font-semibold text-gray-700 underline mb-1">Campaign Description</h2>
                <p class="text-gray-800 mt-2"><?php echo htmlspecialchars($campaign['campDesc']); ?></p>
                <p class="text-gray-800 mt-2">
                <p class="text-xl font-semibold text-gray-800">Challenges:</p> <?php echo htmlspecialchars($campaign['challenges']); ?></p>
                <p class="text-gray-800 mt-2">
                <p class="text-xl font-semibold text-gray-800">Solutions:</p> <?php echo htmlspecialchars($campaign['solutions']); ?></p>
                <p class="text-blue-700 mt-4 text-3xl"><b class="text-gray-800 ">Target Goal:</b> $<?php echo number_format($campaign['targetGoal']); ?></p>
            </div>

            <!-- Organization Details -->
            <h2 class="text-lg pl-2 font-bold mt-14 mb-1 text-gray-700 italic">About the NGO</h2>
            <div class="bg-white rounded-lg shadow-lg p-10 ml-1">
                <div class="flex items-center">
                    <img src="<?php echo htmlspecialchars($organization['logo']); ?>" alt="Logo" class="md:h-12 md:w-12 w-6 mr-4">
                    <h3 class="md:text-xl font-semibold text-gray-700"><?php echo htmlspecialchars($organization['orgName']); ?></h3>
                </div>
                <p class="text-gray-700 mt-4"><?php echo htmlspecialchars($organization['orgDesc']); ?></p>
                <p class="text-gray-500 mt-4"><span class="font-bold"><b>Location:</b></span> <?php echo htmlspecialchars($organization['location']); ?></p>
                <p class="text-gray-500 mt-2">
                    <span class="font-bold"><b>Website:</b></span>
                    <a href="<?php echo htmlspecialchars($organization['website']); ?>" class="text-blue-600 hover:underline"><?php echo htmlspecialchars($organization['website']); ?></a>
                </p>
            </div>
        </div>

        <?php
        // Assuming $campaignId is defined and holds the ID of the current campaign
        $donationQuery = "SELECT SUM(amount) AS total_donated, GROUP_CONCAT(username SEPARATOR ', ') AS username FROM donations WHERE campId = '$campaignId'";
        $donationResult = mysqli_query($con, $donationQuery);
        $donationData = mysqli_fetch_assoc($donationResult);

        $totalDonated = $donationData['total_donated'] ?? 0;
        $donorNames = $donationData['username'] ?? 'No donors yet';

        $donationQuery = "SELECT username, amount FROM donations WHERE campId = '$campaignId'";
$donationResult = mysqli_query($con, $donationQuery);
        ?>

        <!-- Right Fixed Sidebar -->
        <div class="md:w-1/4 p-4 bg-white shadow-lg md:ml-4 md:h-screen md:fixed right-0 top-0">
            <h2 class="text-xl font-bold mb-4">Donate Now</h2>

            <div class="bg-gray-200 rounded-full h-2 md:mb-4">
                <?php
                // Calculate the donation progress percentage
                $percentage = ($campaign['targetGoal'] > 0)
                    ? min(100, ($campaign['achievedGoal'] / $campaign['targetGoal']) * 100)
                    : 0;
                ?>
                <div class="bg-blue-600 h-2" style="width: <?php echo $percentage; ?>%;"></div>
            </div>

            <p class="text-sm text-gray-500 mb-2">
                Amount Raised: <?php echo number_format($totalDonated); ?> birr
            </p>
            <p class="text-sm text-gray-500 mb-4">
                Target Goal: <?php echo number_format($campaign['targetGoal']); ?> birr
            </p>

            <h3 class="text-lg font-bold mb-2">Donors:</h3>
            <ul class="text-sm text-gray-600">
                <?php
                // Fetch donation details
                if (mysqli_num_rows($donationResult) > 0) {
                    while ($donationData = mysqli_fetch_assoc($donationResult)) {
                        $username = htmlspecialchars($donationData['username']);
                        $amount = number_format($donationData['amount']);
                        echo "<li class='mb-1'><span class='font-semibold'>$username</span>: $amount birr</li>";
                    }
                } else {
                    echo "<li>No donors yet</li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });
        });
    </script>

</body>

</html>