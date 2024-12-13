<?php
ob_start();
session_start();

if (isset($_SESSION['orgName']) && isset($_COOKIE['orgName'])) {
  $logOrg = $_SESSION['orgName'];
  $sql = "SELECT * FROM `Organization` WHERE `orgName` = '$logOrg'";
  $rs = mysqli_query($con, $sql);
  $result = mysqli_fetch_assoc($rs);
  $pp = $result['logo'];

  // Fetch notifications
  $notificationsQuery = "SELECT * FROM fNotification WHERE orgName = '$logOrg' ORDER BY created_at DESC";
  $notificationsResult = mysqli_query($con, $notificationsQuery);
  $notifications = mysqli_fetch_all($notificationsResult, MYSQLI_ASSOC);

  // Count unread notifications
  $unreadCount = 0;
  foreach ($notifications as $notification) {
    if ($notification['is_read'] == 0) {
      $unreadCount++;
    }
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

      .navel:hover {
        --tw-bg-opacity: 1;
        color: rgb(229 211 179 / var(--tw-text-opacity));
        padding: 25px;
        background-color: rgb(102 66 41 / var(--tw-bg-opacity));
      }

      .pp:hover {
        transform: scale(1.1);
      }
    </style>
  </head>

  <body>
    <header id="header" class="p-2 pr-6 py-3 flex justify-between items-center text-gray-800 fixed w-full z-20 transition-all duration-300 bg-transparent">
      <div class="flex items-center">
        <img src="./img/logo.png" alt="Logo" class="w-14" />
        <span class="text-lg font-bold text-sky-900">Bright Futures</span>
      </div>
      <nav class="flex flex-grow justify-end space-x-8 text-lg text-sky-900">
        <a href="/Charity/src/findex.php" class="mr-4 <?php echo ($_SERVER['PHP_SELF'] == '/Charity/src/findex.php') ? 'text-blue-600 border-blue-600 border-b-2' : 'hover:text-blue-600 hover:border-blue-600 hover:border-b-2 duration-200'; ?>">Campaigns</a>
      </nav>
      <div class="flex space-x-4">
        <div class="relative">
          <button type="submit" name="not" id="notificationButton" class="notification-icon relative">
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
                  <?php if ($notification['is_read'] == 0): ?>
                    <a href="markread.php?id=<?php echo $notification['id']; ?>" class="text-blue-500 hover:underline">Mark as Read</a>
                  <?php endif; ?>
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
        <a href="pporg.php?orgName=<?php echo $result['orgName']; ?>" class="pp ml-2 flex items-center duration-300">
          <img class="mx-auto rounded-full w-8 h-8 object-center object-cover" src="<?php echo $pp; ?>" alt="pp">
        </a>
      </div>
    </header>
    <script>
      document.getElementById('notificationButton').onclick = function(event) {
        event.stopPropagation(); // Prevent bubbling
        const popup = document.getElementById('notificationPopup');
        popup.classList.toggle('hidden'); // Show/hide popup
        $unreadCount = 0;

      };

      document.getElementById('closePopup').onclick = function(event) {
        event.stopPropagation(); // Prevent bubbling
        document.getElementById('notificationPopup').classList.add('hidden'); // Hide popup
      };

      window.onclick = function(event) {
        const popup = document.getElementById('notificationPopup');
        const button = document.getElementById('notificationButton');
        if (event.target !== popup && event.target !== button && !popup.contains(event.target)) {
          popup.classList.add('hidden'); // Hide popup
        }
      };
    </script>
  </body>

  </html>

<?php
}
ob_end_flush(); // End output buffering
?>