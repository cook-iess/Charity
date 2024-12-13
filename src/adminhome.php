<?php
// Start the session
session_start();
include("conn.php"); // Include your database connection

// Query to get counts for Users, Organizations, Charities, and Donations
$userCountQuery = "SELECT COUNT(*) as count FROM User"; // Adjust table name
$organizationCountQuery = "SELECT COUNT(*) as count FROM Organization"; // Adjust table name
$charityCountQuery = "SELECT COUNT(*) as count FROM Charity"; // Adjust table name
$donationTotalQuery = "SELECT SUM(amount) as total FROM Donations"; // Adjust table name

// New queries for detailed reports
$topDonorsQuery = "SELECT username, SUM(amount) as total_donated 
                   FROM Donations 
                   GROUP BY username 
                   ORDER BY total_donated DESC 
                   LIMIT 5"; // Top 5 donors

$donationsByOrganizationQuery = "SELECT orgName AS organization_name, SUM(d.amount) AS total_donated 
                                  FROM Donations d 
                                  JOIN Organization o ON d.campId = o.id 
                                  GROUP BY orgName"; // Total donations by organization

$donationsOverTimeQuery = "SELECT DATE(created_at) as donation_date, SUM(amount) as total_donated 
                            FROM Donations 
                            GROUP BY donation_date 
                            ORDER BY donation_date"; // Donations over time

// Execute queries
$userCountResult = mysqli_query($con, $userCountQuery);
$organizationCountResult = mysqli_query($con, $organizationCountQuery);
$charityCountResult = mysqli_query($con, $charityCountQuery);
$donationTotalResult = mysqli_query($con, $donationTotalQuery);

$topDonorsResult = mysqli_query($con, $topDonorsQuery);
$donationsByOrganizationResult = mysqli_query($con, $donationsByOrganizationQuery);
$donationsOverTimeResult = mysqli_query($con, $donationsOverTimeQuery);

// Fetch data
$userCount = mysqli_fetch_assoc($userCountResult)['count'];
$organizationCount = mysqli_fetch_assoc($organizationCountResult)['count'];
$charityCount = mysqli_fetch_assoc($charityCountResult)['count'];
$donationTotal = mysqli_fetch_assoc($donationTotalResult)['total'];

$topDonors = [];
while ($row = mysqli_fetch_assoc($topDonorsResult)) {
    $topDonors[] = $row;
}

$donationsByOrganization = [];
while ($row = mysqli_fetch_assoc($donationsByOrganizationResult)) {
    $donationsByOrganization[] = $row;
}

$donationsOverTime = [];
while ($row = mysqli_fetch_assoc($donationsOverTimeResult)) {
    $donationsOverTime[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <h3 class="text-lg font-semibold">Welcome to the Admin Dashboard</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                    <!-- Users Chart -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Users</h4>
                        <canvas id="usersChart" width="400" height="200"></canvas>
                    </div>

                    <!-- Organizations Chart -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Organizations</h4>
                        <canvas id="organizationsChart" width="400" height="200"></canvas>
                    </div>

                    <!-- Charities Chart -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Charities</h4>
                        <canvas id="charitiesChart" width="400" height="200"></canvas>
                    </div>

                    <!-- Donations Chart -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Donations</h4>
                        <canvas id="donationsChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <!-- Top Donors Chart -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Top Donors</h4>
                        <canvas id="topDonorsChart" width="400" height="200"></canvas>
                    </div>

                    <!-- Donations by Organization Chart -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Donations by Organization</h4>
                        <canvas id="donationsByOrganizationChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4 mt-6">
                    <h4 class="font-semibold mb-2">Donations Over Time</h4>
                    <canvas id="donationsOverTimeChart" width="400" height="200"></canvas>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Data from the database
        const userCount = <?php echo $userCount; ?>;
        const organizationCount = <?php echo $organizationCount; ?>;
        const charityCount = <?php echo $charityCount; ?>;
        const donationTotal = <?php echo $donationTotal; ?>;

        // Top Donors data
        const topDonors = <?php echo json_encode($topDonors); ?>;
        const topDonorLabels = topDonors.map(donor => donor.userId); // Assuming userId is the label
        const topDonorValues = topDonors.map(donor => donor.total_donated);

        // Donations by Organization data
        const donationsByOrganization = <?php echo json_encode($donationsByOrganization); ?>;
        const organizationLabels = donationsByOrganization.map(org => org.organization_name);
        const organizationValues = donationsByOrganization.map(org => org.total_donated);

        // Donations Over Time data
        const donationsOverTime = <?php echo json_encode($donationsOverTime); ?>;
        const timeLabels = donationsOverTime.map(donation => donation.donation_date);
        const timeValues = donationsOverTime.map(donation => donation.total_donated);

        // Chart configurations
        const ctxUsers = document.getElementById('usersChart').getContext('2d');
        const ctxOrganizations = document.getElementById('organizationsChart').getContext('2d');
        const ctxCharities = document.getElementById('charitiesChart').getContext('2d');
        const ctxDonations = document.getElementById('donationsChart').getContext('2d');
        const ctxTopDonors = document.getElementById('topDonorsChart').getContext('2d');
        const ctxDonationsByOrganization = document.getElementById('donationsByOrganizationChart').getContext('2d');
        const ctxDonationsOverTime = document.getElementById('donationsOverTimeChart').getContext('2d');

        // Users Chart
        new Chart(ctxUsers, {
            type: 'bar',
            data: {
                labels: ['Total Users'],
                datasets: [{
                    label: 'Users',
                    data: [userCount],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Organizations Chart
        new Chart(ctxOrganizations, {
            type: 'pie',
            data: {
                labels: ['Total Organizations'],
                datasets: [{
                    label: 'Organizations',
                    data: [organizationCount],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                }]
            }
        });

        // Charities Chart
        new Chart(ctxCharities, {
            type: 'line',
            data: {
                labels: ['Total Charities'],
                datasets: [{
                    label: 'Charities',
                    data: [charityCount],
                    borderColor: 'rgba(255, 206, 86, 1)',
                    fill: false,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Donations Chart
        new Chart(ctxDonations, {
            type: 'doughnut',
            data: {
                labels: ['Total Donations'],
                datasets: [{
                    label: 'Donations',
                    data: [donationTotal],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                }]
            }
        });

        // Top Donors Chart
        new Chart(ctxTopDonors, {
            type: 'bar',
            data: {
                labels: topDonorLabels,
                datasets: [{
                    label: 'Top Donors',
                    data: topDonorValues,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Donations by Organization Chart
        new Chart(ctxDonationsByOrganization, {
            type: 'bar',
            data: {
                labels: organizationLabels,
                datasets: [{
                    label: 'Donations by Organization',
                    data: organizationValues,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Donations Over Time Chart
        new Chart(ctxDonationsOverTime, {
            type: 'line',
            data: {
                labels: timeLabels,
                datasets: [{
                    label: 'Donations Over Time',
                    data: timeValues,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>