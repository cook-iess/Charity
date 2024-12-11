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

    <div class="container mx-auto flex">
        <!-- Main Content -->
        <div class="w-3/4 p-4 overflow-auto">
            <div class="">
                <h1 class="text-5xl font-bold mb-6 text-center bg-blue-600 rounded-xl text-white py-4"><?php echo htmlspecialchars($campaign['campTitle']); ?></h1>
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
                <h2 class="text-3xl font-semibold text-gray-700 underline mb-1">Campaign Description</h2>
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
                    <img src="<?php echo htmlspecialchars($organization['logo']); ?>" alt="Logo" class="h-12 w-12 mr-4"> <!-- Adjust size as needed -->
                    <h3 class="text-xl font-semibold text-gray-700"><?php echo htmlspecialchars($organization['orgName']); ?></h3>
                </div>
                <p class="text-gray-700 mt-4"><?php echo htmlspecialchars($organization['orgDesc']); ?></p>
                <p class="text-gray-500 mt-4"><span class="font-bold"><b>Location:</b></span> <?php echo htmlspecialchars($organization['location']); ?></p>
                <p class="text-gray-500 mt-2">
                    <span class="font-bold"><b>Website:</b></span>
                    <a href="<?php echo htmlspecialchars($organization['website']); ?>" class="text-blue-600 hover:underline"><?php echo htmlspecialchars($organization['website']); ?></a>
                </p>
            </div>
        </div>

        <!-- Right Fixed Sidebar -->
        <div class="w-1/4 p-4 bg-white shadow-lg ml-4 h-screen fixed right-0 top-0">
            <h2 class="text-xl font-bold mb-4">Donate Now</h2>
            <div class="bg-gray-200 rounded-full h-2 mb-4">
                <?php
                // Calculate the percentage
                $percentage = ($campaign['targetGoal'] > 0)
                    ? min(100, ($campaign['achievedGoal'] / $campaign['targetGoal']) * 100)
                    : 0;
                ?>
                <div class="bg-blue-600 h-2" style="width: <?php echo $percentage; ?>%;"></div>
            </div>
            <p class="text-sm text-gray-500 mb-2">
                Amount Raised: <?php echo number_format($campaign['achievedGoal']); ?> birr
            </p>
            <p class="text-sm text-gray-500 mb-4">
                Target Goal: <?php echo number_format($campaign['targetGoal']); ?> birr
            </p>
            <div class="flex flex-col space-y-2 mb-6">
                <div class="flex flex-col space-y-2 mb-6">
                    <a href="donate.php?id=<?php echo $campaignId; ?>&amount=1000" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Donate 1,000 birr</a>
                    <a href="donate.php?id=<?php echo $campaignId; ?>&amount=5000" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Donate 5,000 birr</a>
                    <a href="donate.php?id=<?php echo $campaignId; ?>&amount=10000" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Donate 10,000 birr</a>
                    <a href="donate.php?id=<?php echo $campaignId; ?>" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Custom Amount</a>
                </div>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold mb-2">Why Donate?</h3>
                <ul class="list-disc list-inside text-sm text-gray-600">
                    <li><i class="fas fa-heart mr-2 text-red-600"></i>Your contribution helps those in need.</li>
                    <li><i class="fas fa-hand-holding-heart mr-2 text-yellow-500"></i>Support our community initiatives.</li>
                    <li><i class="fas fa-chart-line mr-2 text-green-700"></i>Be part of our growth and success.</li>
                </ul>
            </div>

            <p class="text-sm text-gray-600 mb-4">
                Your support makes a difference! Every contribution helps us reach our goals.
            </p>
            <p class="text-sm text-gray-600 mb-4">
                Thank you for considering a donation. Together, we can make a positive impact!
            </p>

            <div class="flex flex-col space-y-2">
                <a href="#contact" class="flex items-center text-gray-600 hover:text-blue-600">
                    <i class="fas fa-envelope mr-2"></i>Contact Us
                </a>
                <a href="#about" class="flex items-center text-gray-600 hover:text-blue-600">
                    <i class="fas fa-info-circle mr-2"></i>About Us
                </a>
                <a href="#updates" class="flex items-center text-gray-600 hover:text-blue-600">
                    <i class="fas fa-newspaper mr-2"></i>Latest Updates
                </a>
            </div>
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