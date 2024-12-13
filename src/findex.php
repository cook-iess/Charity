<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");
require "./shared/fheader.php";

if (isset($_SESSION['orgName']) && isset($_COOKIE['orgName'])) {

    $orgName = $_SESSION['orgName'];

    $searchTerm = '';
    if (isset($_POST['search'])) {
        $searchTerm = mysqli_real_escape_string($con, $_POST['search']);
    }

    // Fetch campaigns from the database
    $query = "SELECT * FROM Charity WHERE orgName = '$orgName'";
    if (!empty($searchTerm)) {
        $query .= " AND campTitle LIKE '%$searchTerm%'";
    }
    $result = mysqli_query($con, $query);

    $campaigns = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $campaigns[] = $row;
    }

?>

    <!doctype html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="./output.css" rel="stylesheet">
        <title>Manage Campaigns</title>
        <style>
            .bg-cover {
                background-size: cover;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <div class="mb-4 text-xl pt-4 text-white">wsg</div>

        <div class="px-4 md:px-12 mt-16 w-full">
            <h1 class="md:text-4xl text-xl font-extrabold text-sky-700 md:mb-6 pl-6">Manage Charity Campaigns</h1>
            <hr class="border-0 h-px bg-sky-800 w-36 mb-10 ml-6" />

            <div class="flex mb-3 ml-4"> <a
                    href="postCharity.php?orgName=<?php echo $orgName; ?>"
                    class="bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition">
                    New Campaign
                </a></div>

            <!-- Search Form -->
            <input type="text" id="search" placeholder="Search by campaign name" class="border rounded-lg p-2 mb-6 ml-4" />

            <div id="campaigns" class="space-y-12 max-w-6xl mb-10 mx-auto">
                <?php foreach ($campaigns as $campaign): ?>
                    <?php
                    $photoPaths = explode(',', $campaign['photo_paths']);
                    $backgroundImage = !empty($photoPaths[0]) ? $photoPaths[0] : 'default-bg.jpg';
                    ?>
                    <div class="campaign rounded-lg shadow-md overflow-hidden border border-gray-300 mb-8">
                        <div class="h-64 bg-cover bg-center"
                            style="background-image: url('<?php echo htmlspecialchars($backgroundImage); ?>');">
                        </div>
                        <div class="p-6 bg-gray-50">
                            <h2 class="text-2xl font-bold text-gray-900">
                                <?php echo htmlspecialchars($campaign['campTitle']); ?>
                            </h2>
                            <p class="text-gray-500 mt-1 italic text-xs">
                                Posted By: <?php echo htmlspecialchars($campaign['orgName']); ?>
                            </p>
                            <p class="mt-2 text-sm text-gray-700">
                                <?php echo htmlspecialchars($campaign['campDesc']); ?>
                            </p>
                            <p class="text-gray-500 mt-4 text-sm">
                                <span class="font-semibold">Target Goal:</span>
                                $<?php echo number_format($campaign['targetGoal']); ?>
                            </p>
                            <div class="flex mt-4 space-x-3">
                                <a
                                    href="detailCharity.php?id=<?php echo $campaign['id']; ?>"
                                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 shadow-lg transition">
                                    See Status
                                </a>
                                <a
                                    href="editCharity.php?id=<?php echo $campaign['id']; ?>"
                                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 shadow-lg transition">
                                    Edit
                                </a>
                                <a href="deleteCharity.php?id=<?php echo $campaign['id']; ?>"
                                    class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 shadow-lg transition"
                                    onclick="return confirm('Are you sure you want to close this charity?');">
                                    Close
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- footer -->
        <div class="bg-blue-600 text-white pt-3 pb-6 md:flex md:items-center">
            <div class="container mx-auto px-4">
                <div class="flex justify-center items-center pt-0 mt-0">
                    <img src="./img/logo.png" alt="Logo" class="md:w-24 w-10" />
                    <h2 class="text-white font-bold md:text-xl">Bright Futures</h2>
                </div>

                <div class="flex flex-col md:flex-row justify-between w-full mb-16">
                    <div class="w-full md:w-1/3 mb-4 md:mb-0 text-center">
                        <h4 class="md:text-xl font-bold pb-1">Navigation</h4>
                        <a href="/" class="text-white hover:underline block">Home</a>
                        <a href="/projects" class="text-white hover:underline block">Our Projects</a>
                        <a href="/about" class="text-white hover:underline block">About Us</a>
                        <a href="/about#contact-us" class="text-white hover:underline block">Contact Us</a>
                    </div>

                    <div class="w-full md:w-1/3 mb-4 md:mb-0 text-center">
                        <h4 class="md:text-xl font-bold pb-2">Get Involved</h4>
                        <p>Join us in our mission to support the community. <b>Together, we can make a difference!</b></p>
                        <a href="/about" class="hover:underline text-white">Learn More</a>
                    </div>

                    <div class="w-full md:w-1/3 text-center">
                        <h4 class="text-xl font-bold pb-2">Contact Us</h4>
                        <p><b>Email:</b> <a href="mailto:info@brightfutures.org" class="underline">info@brightfutures.org</a></p>
                        <p><b>Phone:</b> <a href="tel:+1234567890" class="underline">+1 (234) 567-890</a></p>
                        <p><b>Address:</b> 123 Bright St, City, State, ZIP</p>
                        <div class="flex justify-center mt-2">
                            <a href="https://facebook.com" class="flex items-center justify-center p-2 text-white">
                                <i class="fab fa-facebook-f text-2xl hover:text-3xl duration-500"></i>
                            </a>
                            <a href="https://twitter.com" class="flex items-center justify-center p-2 text-white">
                                <i class="fab fa-twitter text-2xl hover:text-3xl duration-500"></i>
                            </a>
                            <a href="https://instagram.com" class="flex items-center justify-center p-2 text-white">
                                <i class="fab fa-instagram text-2xl hover:text-3xl duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="my-3 bg-white h-px mb-6"></div>

                <div class="text-center mb-4">
                    <p>© <?php echo date('Y'); ?> Bright Futures. All rights reserved.</p>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#search').on('input', function() {
                    var searchTerm = $(this).val();

                    $.ajax({
                        url: 'search.php', // This is your search handler file
                        type: 'POST',
                        data: {
                            search: searchTerm
                        },
                        success: function(data) {
                            $('#campaigns').html(data);
                        }
                    });
                });
            });
        </script>

    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>