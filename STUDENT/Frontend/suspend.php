<?php
session_start();

// Optionally, you can check if the user is logged in and has a suspended status
if (!isset($_SESSION['client']) || $_SESSION['client']['status'] !== 'suspended') {
    // If the user is not suspended, redirect them to the home page or login page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspended - Youdemy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h1 class="text-2xl font-semibold mb-4 text-red-600">Your Account is Suspended</h1>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                We're sorry, but your account has been suspended due to policy violations. Please contact support for more information.
            </p>
            <a href="contact.php" class="text-blue-600 hover:underline">Contact Support</a>
            <div class="mt-4">
                <a href="index.php" class="text-gray-500 hover:underline">Return to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
