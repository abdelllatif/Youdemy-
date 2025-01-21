<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Role - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dark-transition { transition: background-color 0.3s ease, color 0.3s ease; }
        .role-card:hover { transform: translateY(-5px); }
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
        <div class="max-w-4xl w-full space-y-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold dark-transition text-gray-900 dark:text-white mb-4">Choose Your Role</h1>
                <p class="text-gray-600 dark:text-gray-400">Select how you want to use Youdemy</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mt-8">
                <!-- Student Card -->
                <form action="../backend/singin_traitement.php" method="POST">
                    <input type="hidden" name="role" value="student">
                    <button type="submit" class="role-card cursor-pointer transition-all duration-300 dark-transition bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl">
                        <div class="text-center mb-4">
                            <div class="w-20 h-20 mx-auto bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-graduate text-3xl text-blue-600 dark:text-blue-400"></i>
                            </div>
                        </div>
                        <h2 class="text-xl font-semibold text-center dark-transition text-gray-900 dark:text-white mb-4">Student</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-center">Access courses, learn at your own pace, and track your progress</p>
                    </button>
                </form>

                <!-- Professor Card -->
                <form action="../backend/singin_traitement.php" method="POST">
                    <input type="hidden" name="role" value="teacher">
                    <button type="submit" class="role-card cursor-pointer transition-all duration-300 dark-transition bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl">
                        <div class="text-center mb-4">
                            <div class="w-20 h-20 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-3xl text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                        </div>
                        <h2 class="text-xl font-semibold text-center dark-transition text-gray-900 dark:text-white mb-4">Professor</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-center">Create courses, teach students, and share your knowledge</p>
                    </button>
                </form>
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

        function selectRole(role) {
            if (role === 'student') {
                window.location.href = 'index.php';
            } else {
                window.location.href = 'professor-waiting.php';
            }
        }
    </script>
</body>
</html>