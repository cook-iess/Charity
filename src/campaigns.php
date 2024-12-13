<?php
// Start the session
session_start();
include("conn.php"); // Include your database connection

if ($_SESSION['Username'] == 'Admin') {
    // Fetch all campaigns initially
    $campaignsQuery = "
    SELECT id, CampTitle, campDesc, orgName, targetGoal, achievedGoal, challenges, solutions, created_at, updated_at 
    FROM Charity"; // Adjust table name if necessary

    $campaignsResult = mysqli_query($con, $campaignsQuery);

    // Check for deletion
    if (isset($_GET['delete_id'])) {
        $deleteId = intval($_GET['delete_id']);
        $deleteQuery = "DELETE FROM Charity WHERE id = $deleteId"; // Adjust table name if necessary
        mysqli_query($con, $deleteQuery);
        header("Location: campaigns.php"); // Redirect after deletion
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Campaigns</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100">

    <div class="flex">

        <!-- Sidebar -->
        <?php include './shared/adminSidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-1 ml-64">
            <!-- Header -->
            <?php include './shared/adminHeader.php'; ?>

            <main class="pt-16 p-4">
                <h3 class="text-sky-800 font-semibold mt-10 text-2xl">Manage Campaigns</h3>
                
                <!-- Search Input -->
                <input type="text" id="search" placeholder="Search by Campaign Title" class="mt-4 p-2 border rounded w-full" />

                <div class="mt-4" id="campaignsContainer">
                    <?php while ($campaign = mysqli_fetch_assoc($campaignsResult)): ?>
                        <div class="bg-white shadow-md rounded-lg p-6 mb-4 campaign-card">
                            <h4 class="font-semibold text-lg"><?php echo htmlspecialchars($campaign['CampTitle']); ?></h4>
                            <p class="text-gray-600"><strong>Description:</strong> <?php echo htmlspecialchars($campaign['campDesc']); ?></p>
                            <p class="text-gray-600"><strong>Organization Name:</strong> <?php echo htmlspecialchars($campaign['orgName']); ?></p>
                            <p class="text-gray-600"><strong>Target Goal:</strong> $<?php echo htmlspecialchars($campaign['targetGoal']); ?></p>
                            <p class="text-gray-600"><strong>Achieved Goal:</strong> $<?php echo htmlspecialchars($campaign['achievedGoal']); ?></p>
                            <p class="text-gray-600"><strong>Challenges:</strong> <?php echo htmlspecialchars($campaign['challenges']); ?></p>
                            <p class="text-gray-600"><strong>Solutions:</strong> <?php echo htmlspecialchars($campaign['solutions']); ?></p>
                            <p class="text-gray-600"><strong>Created At:</strong> <?php echo htmlspecialchars($campaign['created_at']); ?></p>
                            <p class="text-gray-600"><strong>Updated At:</strong> <?php echo htmlspecialchars($campaign['updated_at']); ?></p>
                            <div class="mt-4">
                                <a href="campaigns.php?delete_id=<?php echo $campaign['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this campaign?');" 
                                   class="text-red-500 hover:underline">Delete Campaign</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: 'search_campaigns.php',
                    method: 'GET',
                    data: { search: query },
                    success: function(data) {
                        $('#campaignsContainer').html(data);
                    }
                });
            });
        });
    </script>

</body>

</html>

<?php
} else {
    header("Location: adminlog.php");
}
?>