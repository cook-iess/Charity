<!-- sidebar.php -->
<aside class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-blue-200 to-white border-r">
    <div class="flex items-center justify-center h-16 border-b">
        <h1 class="text-lg font-bold">Admin Panel</h1>
    </div>
    <nav class="mt-10 text-sky-700">
        <a href="adminHome.php" class="block py-2.5 px-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'adminHome.php') ? 'bg-blue-300' : 'hover:bg-blue-200'; ?>">Dashboard</a>
        <a href="users.php" class="block py-2.5 px-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'bg-blue-300' : 'hover:bg-blue-200'; ?>">Users</a>
        <a href="campaigns.php" class="block py-2.5 px-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'campaigns.php') ? 'bg-blue-300' : 'hover:bg-blue-200'; ?>">Campaigns</a>
        <a href="logout.php" class="block py-2.5 px-4 <?php echo (basename($_SERVER['PHP_SELF']) == 'logout.php') ? 'bg-blue-300' : 'hover:bg-blue-200'; ?>">Logout</a>
    </nav>
</aside>