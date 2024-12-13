<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conn.php");

require "./shared/fheader.php";

if (isset($_SESSION['orgName']) && isset($_COOKIE['orgName'])) {

    $orgName = $_SESSION['orgName'];

    // if (isset($_POST['delete'])) {

    //     $sql = "DELETE FROM Announcements WHERE UserName = '$UserName'";
    //     $sql2 = "DELETE FROM Comments WHERE User_ID = '$UserName'";
    //     $sql3 = "DELETE FROM Favorite WHERE User_ID = '$UserName'";
    //     $sql4 = "DELETE FROM LIKES WHERE User_ID = '$UserName'";
    //     $sql2 = "DELETE FROM BOOK WHERE UserName = '$UserName'";
    //     $sql6 = "DELETE FROM USER WHERE UseName = '$UserName'";

    //     $rs = mysqli_query($con, $sql);

    //     $rs2 = mysqli_query($con, $sql2);

    //     $rs3 = mysqli_query($con, $sql3);

    //     $rs4 = mysqli_query($con, $sql4);

    //     $rs5 = mysqli_query($con, $sql5);

    //     $rs6 = mysqli_query($con, $sql6);

    //     if ($rs && $rs2 && $rs3 && $rs4 && $rs5 && $rs6) {
    //         header("Location: index.php");
    //       } else {
    //         echo "Error deleting record: " . $conn->error;
    //       }

    // }

?>

    <head>
        <link href="./output.css" rel="stylesheet">
        <title>Organization Profile</title>
    </head>

    <body class="bg-blue-100">

        <div class="mb-8 text-6xl text-blue-100">wsg</div>

        <p class="text-3xl text-sky-700 font-bold pl-14">Organization Profile</p>
        <hr class="border-0 h-px bg-sky-800 w-36 mb-10 ml-16 mt-2" />
        <div class="flex justify-end ">
            <div class="flex space-x-2 mr-4 pr-4">
                <div class="my-auto">
                    <a href="editorg.php" class="text-xs rounded-lg mr-3 text-white bg-blue-600 hover:font-extrabold font-bold md:py-3 py-2 md:px-5 px-3 md:text-sm shadow-xl hover:shadow-2xl">Edit Profile</a>
                </div>
                <div class="my-auto">
                    <a href="flogout.php" class="text-xs rounded-lg mr-3 text-white hover:font-extrabold font-bold md:py-3 py-2 md:px-5 px-3 md:text-sm shadow-xl hover:shadow-2xl bg-blue-600">Logout</a>
                </div>
                <div class="my-auto mr-2">
                    <button onclick="confirmDelete(event)" data-delete-url="delorg.php" type="submit" name="delete" class="text-xs rounded-lg mr-3 bg-red-600 text-white hover:font-extrabold font-bold md:py-3 py-2 md:px-5 px-3 md:text-sm shadow-xl hover:shadow-2xl">
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-14 pb-10">
            <?php
            $select = "SELECT * FROM Organization WHERE orgName = '$orgName'";
            $rs = mysqli_query($con, $select);
            $count = mysqli_num_rows($rs);
            if ($count > 0) {
                while ($result = mysqli_fetch_assoc($rs)) {
            ?>
                    <div class="grid md:grid-cols-4 grid-cols-2 gap-4 justify-around">
                        <div class="col-span-1 md:block hidden">

                        </div>
                        <div class="col-span-1">
                            <img class="mx-auto rounded-full m-1 mb-2 md:w-44 md:h-44 w-28 h-28 object-cover object-center" src="<?= $result['logo'] ?>" alt="profile picture">
                        </div>
                        <div class="my-auto md:col-span-2">
                            <h1 class="text-xl md:text-lg font-extrabold"><?php echo $result['orgName'] ?></h1>
                            <p class="text-lg inline-block"><?php echo $result['orgDesc'] ?></p>
                            <div>
                                <p class="text-lg font-bold inline">Location: </p>
                                <p class="text-lg inline-block"><?php echo $result['location'] ?></p>
                            </div>
                            <p class="text-lg font-bold inline">Website:</p>
                            <p class="text-lg inline-block"><?php echo $result['website'] ?></p>
                            <p class="text-sm pt-2 text-gray-900"><b>Joined Date: </b><?php echo $result['joinedDate'] ?></p>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<h2 class='text-center md:text-3xl font-bold mb-5 text-blue-800'>No records found</h2>";
            }
            ?>

        </div>

        <div>
            <p class="text-2xl font-bold py-4 md:mt-8 mb-2 px-10 w-fit text-sky-700">Your Campaigns:</p>
        </div>

        <div class="md:pt-5 pt-0">

            <?php

            function truncateText($text, $maxLength)
            {
                if (strlen($text) > $maxLength) {
                    $text = substr($text, 0, $maxLength) . '...';
                }
                return $text;
            }

            $select = "SELECT * FROM Charity WHERE orgName = '$orgName'";
            $rs = mysqli_query($con, $select);
            $count = mysqli_num_rows($rs);

            if ($count > 0) {
                echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">';
                while ($result = mysqli_fetch_assoc($rs)) {
                    $campId = htmlspecialchars($result['id']); // Get campaign ID
                    $campTitle = htmlspecialchars($result['campTitle']);
                    $campDesc = htmlspecialchars(truncateText($result['campDesc'], 100)); // Truncated description
                    $targetGoal = htmlspecialchars($result['targetGoal']);
                    $achievedGoal = htmlspecialchars($result['achievedGoal']);
                    $createdAt = htmlspecialchars(date("F j, Y", strtotime($result['created_at']))); // Formatted date
            ?>

                    <div class="max-w-sm mx-auto mb-6">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="p-6">
                                <h2 class="font-bold text-xl pb-1 text-sky-700 underline"><?php echo $campTitle; ?></h2>
                                <p class="text-xs mb-2">Posted at: <?php echo $createdAt; ?></p>
                                <p class="pt-1 text-xs mb-4">Description: <?php echo $campDesc; ?></p>
                                <p class="pt-1 text-xs mb-2"><span class="font-semibold">Target Goal:</span> $<?php echo number_format($targetGoal); ?></p>
                                <p class="pt-1 text-xs mb-4"><span class="font-semibold">Achieved Goal:</span> $<?php echo number_format($achievedGoal); ?></p>
                                <a href="fdetail.php?id=<?php echo $campId; ?>" class="text-blue-600 hover:underline text-xs">More</a>
                            </div>
                        </div>
                    </div>

            <?php
                }
                echo '</div>'; // Close the grid container
            } else {
                echo "<h2 class='text-center md:text-3xl font-bold mb-8 text-gray-500'>No Campaigns available yet</h2>";
            }
            ?>

        </div>

        <!-- fotter -->
        <div class="bg-blue-600 text-white pt-3 pb-6 md:flex md:items-center">
            <div class="container mx-auto px-4">
                <!-- Logo and Title -->
                <div class="flex justify-center items-center pt-0 mt-0">
                    <img src="./img/logo.png" alt="Logo" class="md:w-24 w-10" />
                    <h2 class="text-white font-bold md:text-xl">Bright Futures</h2>
                </div>

                <!-- Main Content Area -->
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

            function confirmDelete(event) {
                event.preventDefault();
                let userConfirmed = confirm("Are you sure you want to delete you account?");
                if (userConfirmed) {
                    window.location.href = event.target.getAttribute('data-delete-url');
                }
            }
        </script>

    </body>

    </html>

<?php

} else {
    header("Location: login.php");
}
?>