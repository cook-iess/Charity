<?php
// Start the session
session_start();
include("conn.php"); // Include your database connection

if ($_SESSION['Username'] == 'Admin') {

    // Fetch users and their donations
    $usersQuery = "SELECT * FROM User";
    $usersResult = mysqli_query($con, $usersQuery);

    // Check for deletion
    if (isset($_GET['delete_id'])) {
        $deleteId = intval($_GET['delete_id']);
        $deleteQuery = "DELETE FROM User WHERE id = $deleteId";
        mysqli_query($con, $deleteQuery);
        header("Location: users.php"); // Redirect after deletion
        exit();
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="styles.css">
    </head>

    <body class="bg-gray-100">

        <div class="flex">

            <!-- Include Sidebar -->
            <?php include './shared/adminSidebar.php'; ?>

            <!-- Main content -->
            <div class="flex-1 ml-64">
                <!-- Include Header -->
                <?php include './shared/adminHeader.php'; ?>

                <main class="pt-16 p-4">
                    <h3 class="text-sky-800 font-semibold mt-10 text-2xl">Manage Users</h3>
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border px-4 py-2">Username</th>
                                    <th class="border px-4 py-2">Email</th>
                                    <th class="border px-4 py-2">Donations</th>
                                    <th class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = mysqli_fetch_assoc($usersResult)): ?>
                                    <tr>
                                        <td class="border px-4 py-2"><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td class="border px-4 py-2"><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td class="border px-4 py-2">
                                            <?php
                                            // Fetch donations for the user
                                            $donationsQuery = "SELECT SUM(amount) as total_donations FROM Donations WHERE username = '" . mysqli_real_escape_string($con, $user['username']) . "'";
                                            $donationsResult = mysqli_query($con, $donationsQuery);
                                            $donationData = mysqli_fetch_assoc($donationsResult);
                                            echo htmlspecialchars($donationData['total_donations'] ?: 0);
                                            ?>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <a href="delprofilee.php?id=<?php echo $user['username']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this user?');"
                                                class="text-red-500 hover:underline">Delete User</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>

    </body>

    </html>

<?php
} else {
    header("Location: adminlog.php");
}
?>