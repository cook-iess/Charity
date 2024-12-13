<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($con, $_POST['search']);
}

// Fetch campaigns based on the search term
$query = "SELECT * FROM Charity";
if (!empty($searchTerm)) {
    $query .= " WHERE campTitle LIKE '%$searchTerm%'";
}
$result = mysqli_query($con, $query);

$campaigns = [];
while ($row = mysqli_fetch_assoc($result)) {
    $campaigns[] = $row;
}

// Output the campaigns
foreach ($campaigns as $campaign) {
    $photoPaths = explode(',', $campaign['photo_paths']);
    $backgroundImage = !empty($photoPaths[0]) ? $photoPaths[0] : 'default-bg.jpg'; // Fallback image
    ?>
    <div class="rounded-lg shadow-md overflow-hidden border border-gray-300 mb-8">
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
            <div class="flex mt-4">
                <a
                    href="detailCharity.php?id=<?php echo $campaign['id']; ?>"
                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 shadow-lg transition">
                    Donate Now
                </a>
            </div>
        </div>
    </div>
    <?php
}
?>