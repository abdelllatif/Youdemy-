
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 m-4">
            <div class="text-center">
                <i class="fas fa-times-circle text-red-500 text-6xl mb-4"></i>
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Application Not Approved</h1>
                <p class="text-gray-600 mb-6">
                    We regret to inform you that your application to become an instructor on Youdemy has not been approved at this time.
                </p>
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">What can you do next?</h2>
                    <ul class="text-left text-gray-600 space-y-3 mb-6">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                            Review and update your professional qualifications
                        </li>
                        <li class="
                        flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                            Enhance your teaching portfolio
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                            Wait 30 days before reapplying
                        </li>
                    </ul>
                </div>
                
                <div class="space-y-4">
                    <form action="../../Login/backend/logout.php" method="POST" class="mt-4">
                        <button type="submit" class="text-gray-500 hover:text-gray-700 font-medium">
                        Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 text-gray-500">
        <p>&copy; <?php echo date('Y'); ?> Youdemy. All rights reserved.</p>
    </footer>
</body>
</html>