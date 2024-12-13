<?php
ob_start();
session_start();

if (isset($_SESSION['Username']) && isset($_COOKIE['Username'])) {
    $loguser = $_SESSION['Username'];
    $sql = "SELECT * FROM `User` WHERE `Username` = '$loguser'";
    $rs = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($rs);
    $pp = $result['photo'];

    $userId = $_SESSION['Username'];

    // Fetch notifications
    $notificationsQuery = "SELECT * FROM Notifications WHERE username = '$userId' ORDER BY created_at DESC";
    $notificationsResult = mysqli_query($con, $notificationsQuery);
    $notifications = mysqli_fetch_all($notificationsResult, MYSQLI_ASSOC);

    // Count unread notifications
    $unreadCount = 0;
    foreach ($notifications as $notification) {
        if ($notification['is_read'] == 0) {
            $unreadCount++;
        }
    }

    // Mark notification as read when closing
    if (isset($_GET['mark_read'])) {
        $notificationId = intval($_GET['mark_read']);
        $updateQuery = "UPDATE Notifications SET is_read = 1 WHERE id = ?";
        $stmt = $con->prepare($updateQuery);
        $stmt->bind_param("i", $notificationId);
        $stmt->execute();
        $stmt->close();
        
        // Refresh the page after marking as read
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../output.css">
    <style>
        /* Your existing styles */
        #notificationPopup {
            width: 24rem;
        }

        #notificationPopup .p-4 {
            max-height: 24rem;
            overflow-y: auto;
        }

        .closePopup {
            background-color: rgb(220, 38, 38);
            transition: background-color 0.3s ease;
        }

        .closePopup:hover {
            background-color: rgb(185, 28, 28);
        }

        .hidden {
            display: none;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .nav-links {
                display: none; /* Start hidden */
                flex-direction: column;
                width: 100%;
                background-color: white;
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 1000;
            }

            .nav-links.active {
                display: flex; /* Show when active */
            }

            .hamburger {
                display: flex;
                flex-direction: column;
                cursor: pointer;
            }

            .bar {
                height: 3px;
                width: 25px;
                background-color: #2563eb;
                margin: 3px 0;
                transition: 0.3s;
            }
        }
    </style>
</head>

<body>
    <header id="header" class="p-2 pr-6 py-3 flex justify-between items-center text-gray-800 fixed w-full z-20 transition-all duration-300 bg-transparent">
        <div class="flex items-center">
            <img src="./img/logo.png" alt="Logo" class="w-14" />
            <span class="text-lg font-bold text-sky-900">Bright Futures</span>
        </div>
        <div class="hamburger" id="hamburger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <nav class="md:flex flex-grow justify-center space-x-8 text-lg text-sky-900 nav-links" id="navLinks">
            <a href="/Charity/src/index.php" class="<?php echo ($_SERVER['PHP_SELF'] == '/Charity/src/index.php') ? 'text-blue-600 border-blue-600 border-b-2' : 'hover:text-blue-600 hover:border-blue-600 hover:border-b-2 duration-200'; ?>">Home</a>
            <a href="/Charity/src/projects.php" class="<?php echo ($_SERVER['PHP_SELF'] == '/Charity/src/projects.php') ? 'text-blue-600 border-blue-600 border-b-2' : 'hover:text-blue-600 hover:border-blue-600 hover:border-b-2 duration-200'; ?>">Our Projects</a>
            <a href="/Charity/src/about.php" class="<?php echo ($_SERVER['PHP_SELF'] == '/Charity/src/about.php') ? 'text-blue-600 border-blue-600 border-b-2' : 'hover:text-blue-600 hover:border-blue-600 hover:border-b-2 duration-200'; ?>">About Us</a>
        </nav>
        <div class="flex space-x-4">
            <div class="relative">
                <button type="button" id="notificationButton" class="notification-icon relative">
                    <i class="fas fa-bell text-2xl" style="color: #2563eb !important;"></i>

                    <?php if ($unreadCount > 0): ?>
                        <span class="absolute" style="top: -0.3rem; right: -0.3rem; background-color: #f56565; color: white; width: 1.2rem; height: 1.2rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">
                            <?php echo $unreadCount; ?>
                        </span>
                    <?php endif; ?>
                </button>

                <!-- Popup Notification -->
                <div id="notificationPopup" class="hidden absolute right-0 mt-2 w-96 bg-white border border-gray-300 rounded-lg shadow-lg z-50">
                    <div class="pt-4 px-4 pb-2 max-h-96 overflow-y-auto">
                        <h3 class="font-bold text-gray-700 mb-3">Notifications</h3>
                        <?php foreach ($notifications as $notification): ?>
                            <div class="notification-item border-b pb-2 mb-2">
                                <p class="text-gray-800"><?php echo htmlspecialchars($notification['message']); ?></p>
                                <small class="text-gray-500"><?php echo $notification['created_at']; ?></small>
                                <a href="?mark_read=<?php echo $notification['id']; ?>" class="bg-white closePopup text-sm text-blue-500">Mark as read</a>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($notifications)): ?>
                            <p class="text-gray-500">No notifications available</p>
                        <?php endif; ?>
                    </div>
                    <div class="flex justify-end">
                        <button id="closePopup" class="closePopup text-sm text-white float-right mr-2 mb-2 p-2 px-3 rounded-lg">Close</button>
                    </div>
                </div>
            </div>
            <a href="ppuser.php?UserName=<?php echo $result['username']; ?>" class="pp ml-2 flex items-center duration-300">
                <img class="mx-auto rounded-full w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="Profile Picture">
            </a>
        </div>
    </header>

    <script>
        document.getElementById('hamburger').onclick = function() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active'); // Toggle the active class
        };

        document.getElementById('notificationButton').onclick = function(event) {
            event.stopPropagation(); // Prevent bubbling
            const popup = document.getElementById('notificationPopup');
            popup.classList.toggle('hidden'); // Show/hide popup
        };

        document.getElementById('closePopup').onclick = function(event) {
            event.stopPropagation(); // Prevent bubbling
            const popup = document.getElementById('notificationPopup');
            popup.classList.add('hidden'); // Hide popup
        };

        window.onclick = function(event) {
            const popup = document.getElementById('notificationPopup');
            const button = document.getElementById('notificationButton');
            const navLinks = document.getElementById('navLinks');
            if (event.target !== popup && event.target !== button && !popup.contains(event.target)) {
                popup.classList.add('hidden'); // Hide popup
            }
            if (!navLinks.contains(event.target) && event.target !== document.getElementById('hamburger')) {
                navLinks.classList.remove('active'); // Hide nav if clicked outside
            }
        };
    </script>
</body>

</html>

<?php
}
ob_end_flush(); // End output buffering
?>