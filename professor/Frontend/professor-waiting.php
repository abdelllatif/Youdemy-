<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Under Review - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dark-transition { transition: background-color 0.3s ease, color 0.3s ease; }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .pulse-animation { animation: pulse 2s infinite; }
    </style>
</head>
<body class="dark-transition bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 dark-transition bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">Youdemy</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="toggleDarkMode()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-moon dark:hidden text-gray-600"></i>
                        <i class="fas fa-sun hidden dark:block text-yellow-400"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24 min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full space-y-8">
            <div class="dark-transition bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center">
                <div class="mb-6">
                    <div class="w-24 h-24 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center pulse-animation">
                        <i class="fas fa-hourglass-half text-4xl text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                </div>
                
                <h1 class="text-2xl font-bold dark-transition text-gray-900 dark:text-white mb-4">Application Under Review</h1>
                
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Thank you for your interest in teaching on Youdemy! Our team is reviewing your application. This process typically takes 1-2 business days.
                </p>

                <div class="space-y-4">
                    <div class="dark-transition bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">What happens next?</h3>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 text-left space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                We'll review your credentials and experience
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                If approved, you can start creating courses
                            </li>
                        </ul>
                    </div>

                    <button onclick="window.location.href='index.php'" class="w-full py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Return to Homepage
                    </button>
                </div>
            </div>
        </div>
    </main>
    <footer class="dark-transition bg-gray-800 dark:bg-gray-900 text-white mt-12">
            <div class="max-w-7xl mx-auto py-12 px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Footer content... -->
                </div>
                <div class="mt-8 pt-8 border-t border-gray-700">
                    <p class="text-center text-gray-400">&copy; 2024 Youdemy. All rights reserved.</p>
                </div>
            </div>
        </footer>
    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }

        if (localStorage.getItem('darkMode') === 'true' || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches && 
            !localStorage.getItem('darkMode'))) {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>