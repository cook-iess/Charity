<?php
session_start();
include("conn.php"); // Include your database connection

if ($_SESSION['Username'] == 'Admin') {
    if (isset($_GET['search'])) {
        $search = mysqli_real_escape_string($con, $_GET['search']);
        
        $searchQuery = "
        SELECT id, CampTitle, campDesc, orgName, targetGoal, achievedGoal, challenges, solutions, created_at, updated_at 
        FROM Charity 
        WHERE CampTitle LIKE '%$search%'"; // Adjust table name if necessary

        $searchResult = mysqli_query($con, $searchQuery);

        while ($campaign = mysqli_fetch_assoc($searchResult)): ?>
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
        <?php endwhile;
    }
} else {
    header("Location: adminlog.php");
}
?>