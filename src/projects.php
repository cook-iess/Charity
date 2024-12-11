<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require "./shared/header.php";

if (isset($_SESSION['Username']) && isset($_COOKIE['Username'])) {

    // Fetch campaigns from the database
    $query = "SELECT * FROM Charity";
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
        <title>Charity Campaigns</title>
        <style>
            .bg-cover {
                background-size: cover;
            }
        </style>
    </head>

    <body>
        <div class="mb-8 h-60 text-6xl text-white">wsg</div>

        <div class="px-4 md:px-12 mt-32 w-full">
            <h1 class="text-4xl font-extrabold text-sky-700 mb-6 pl-6">Charity Campaigns</h1>
            <hr class="border-0 h-px bg-sky-800 w-36 mb-10 ml-6" />

            <div class="space-y-12 max-w-4xl mx-auto px-8">
                <?php foreach ($campaigns as $campaign): ?>
                    <?php
                    // Get the first image path
                    $photoPaths = explode(',', $campaign['photo_paths']);
                    $backgroundImage = !empty($photoPaths[0]) ? $photoPaths[0] : 'default-bg.jpg'; // Fallback image
                    ?>
                    <div class="rounded-lg shadow-md overflow-hidden border border-gray-300 mb-8">
                        <!-- Campaign Image -->
                        <div class="h-64 bg-cover bg-center"
                            style="background-image: url('<?php echo htmlspecialchars($backgroundImage); ?>');">
                        </div>
                        <!-- Campaign Content -->
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
                            <div class="flex mt-4">
                                <a
                                    href="detailCharity.php?id=<?php echo $campaign['id']; ?>"
                                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 shadow-lg transition">
                                    Donate Now
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>





        <!-- footer -->
        <div
            class="bg-blue-600 text-white pt-3 pb-6 flex flex-col items-center">
            <div>
                <!-- Logo and Title -->
                <div class="flex justify-center items-center pt-0 mt-0">
                    <img src="./img/logo.png" alt="Logo" class="w-24" />
                    <h2 class="text-white font-bold text-xl">Bright Futures</h2>
                </div>

                <!-- Main Content Area -->
                <div class="flex flex-1 justify-between w-full mb-16">
                    <div class="w-1/3 mr-4 mx-auto text-center">
                        <h4 class="text-xl font-bold pb-1">Navigation</h4>
                        <a href="/" class="text-white hover:underline block">
                            Home
                        </a>
                        <a
                            href="/projects"
                            class="text-white hover:underline block">
                            Our Projects
                        </a>
                        <a
                            href="/about"
                            class="text-white hover:underline block">
                            About Us
                        </a>
                        <a
                            href="/about#contact-us"
                            class="text-white hover:underline block">
                            Contact Us
                        </a>
                    </div>

                    <div class="text-center w-1/3">
                        <h4 class="text-xl font-bold pb-2">Get Involved</h4>
                        <p class="">
                            Join us in our mission to support the community.
                            <b>Together, we can make a difference!</b>
                        </p>
                        <a href="/about" class="hover:underline text-white">
                            Learn More
                        </a>
                    </div>

                    <div class="w-1/3 text-center">
                        <h4 class="text-xl font-bold pb-2">Contact Us</h4>
                        <p>
                            <b>Email:</b>
                            <a href="mailto:info@brightfutures.org" class="underline">
                                info@brightfutures.org
                            </a>
                        </p>
                        <p>
                            <b>Phone:</b>
                            <a href="tel:+1234567890" class="underline">
                                +1 (234) 567-890
                            </a>
                        </p>
                        <p><b>Address:</b> 123 Bright St, City, State, ZIP</p>
                        <div class="flex justify-center">
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
                    <p>
                        © <?php echo date('Y'); ?> Bright Futures. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

        <script>
            const header = document.getElementById('header');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.remove('bg-transparent');
                    header.classList.add('bg-white', 'shadow-lg');
                } else {
                    header.classList.add('bg-transparent');
                    header.classList.remove('bg-white', 'shadow-lg');
                }
            });
        </script>

    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>