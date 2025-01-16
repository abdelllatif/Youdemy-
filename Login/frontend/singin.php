<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dark-transition {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body class="dark-transition bg-gray-50 dark:bg-gray-900">
    <!-- Navigation (simplified for auth pages) -->
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
    <main class="pt-16 min-h-screen flex items-center justify-center px-4">
        <div class="max-w-sm w-full space-y-6 animate-fade-in">
            <!-- Toggle Buttons -->
            <div class="flex justify-center mb-4">
                <button id="signUpBtn" onclick="showSignUp()" class="px-3 py-1 mx-1 bg-blue-600 text-white rounded-lg">Sign Up</button>
                <button id="signInBtn" onclick="showSignIn()" class="px-3 py-1 mx-1 bg-gray-300 dark:bg-gray-700 dark:text-white rounded-lg">Sign In</button>
            </div>

            <!-- Sign Up Form Card -->
            <div id="signUpForm" class="dark-transition bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="text-center mb-4">
                    <h2 class="text-2xl font-bold dark-transition text-gray-900 dark:text-white">Create Account</h2>
                </div>

                <!-- Social Sign Up Buttons -->
                <!-- <div class="grid grid-cols-2 gap-2 mb-4">
                    <button class="flex items-center justify-center px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <img src="https://www.habitat44.org/wp-content/uploads/2020/06/53-533322_linked-in-logo-linkedin-logo-png-images-free.jpg" alt="Google" class="w-5 h-5 mr-1">
                        <span class="dark-transition text-gray-700 dark:text-gray-300 text-sm">Google</span>
                    </button>
                    <button class="flex items-center justify-center px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <img src="/api/placeholder/24/24" alt="Facebook" class="w-5 h-5 mr-1">
                        <span class="dark-transition text-gray-700 dark:text-gray-300 text-sm">Facebook</span>
                    </button>
                </div>

                <div class="relative mb-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 dark-transition bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">Or continue with</span>
                    </div>
                </div> -->

                <!-- Sign Up Form -->
                <form class="space-y-4" action="../backend/set_session.php" method="POST">
                    <div class="space-y-2">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm font-medium dark-transition text-gray-700 dark:text-gray-300 mb-1">First Name</label>
                                <input name="FirstName" type="text" class="w-full px-3 py-1 rounded-lg border dark-transition bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:text-white text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium dark-transition text-gray-700 dark:text-gray-300 mb-1">Last Name</label>
                                <input name="LastName" type="text" class="w-full px-3 py-1 rounded-lg border dark-transition bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:text-white text-sm" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium dark-transition text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input name="email" type="email" class="w-full px-3 py-1 rounded-lg border dark-transition bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:text-white text-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium dark-transition text-gray-700 dark:text-gray-300 mb-1">Password</label>
                            <div class="relative">
                                <input name="password" type="password" class="w-full px-3 py-1 rounded-lg border dark-transition bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:text-white text-sm" required>
                                <button type="button" class="absolute right-2 top-2 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium dark-transition text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                            <div class="relative">
                                <input name="verifier_password" type="password" class="w-full px-3 py-1 rounded-lg border dark-transition bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:text-white text-sm" required>
                                <button type="button" class="absolute right-2 top-2 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
                        <label class="ml-2 block text-sm dark-transition text-gray-700 dark:text-gray-300">
                            I agree to the <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-2 px-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Create Account
                    </button>
                </form>
            </div>

            <!-- Sign In Form Card -->
            <div id="signInForm" class="dark-transition bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hidden">
                <div class="text-center mb-4">
                    <h2 class="text-2xl font-bold dark-transition text-gray-900 dark:text-white">Sign In</h2>
                </div>
                <!-- Social Sign In Buttons -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <button class="flex items-center justify-center px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <img src="/api/placeholder/24/24" alt="Google" class="w-5 h-5 mr-1">
                        <span class="dark-transition text-gray-700 dark:text-gray-300 text-sm">Google</span>
                    </button>
                    <button class="flex items-center justify-center px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <img src="/api/placeholder/24/24" alt="Facebook" class="w-5 h-5 mr-1">
                        <span class="dark-transition text-gray-700 dark:text-gray-300 text-sm">Facebook</span>
                    </button>
                </div>

                <div class="relative mb-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 dark-transition bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">Or continue with</span>
                    </div>
                </div>
             
                <!-- Sign In Form -->
                <form class="space-y-4" action="../backend/login.php" method="POST" >
                    <div class="space-y-2">
                        <div>
                            <label class="block text-sm font-medium dark-transition text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input name="email" type="email" class="w-full px-3 py-1 rounded-lg border dark-transition bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:text-white text-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium dark-transition text-gray-700 dark:text-gray-300 mb-1">Password</label>
                            <div class="relative">
                                <input name="password" type="password" class="w-full px-3 py-1 rounded-lg border dark-transition bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:text-white text-sm" required>
                                <button type="button" class="absolute right-2 top-2 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm dark-transition text-gray-700 dark:text-gray-300">Remember me</label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">Forgot your password?</a>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2 px-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </main>
      <!-- Footer -->
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
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('darkMode', isDark);
        }

        if (localStorage.getItem('darkMode') === 'true' || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches && 
            !localStorage.getItem('darkMode'))) {
            document.documentElement.classList.add('dark');
        }

        function showSignUp() {
            document.getElementById('signUpForm').classList.remove('hidden');
            document.getElementById('signInForm').classList.add('hidden');
            document.getElementById('signUpBtn').classList.add('bg-blue-600', 'text-white');
            document.getElementById('signUpBtn').classList.remove('bg-gray-300', 'dark:bg-gray-700', 'dark:text-white');
            document.getElementById('signInBtn').classList.add('bg-gray-300', 'dark:bg-gray-700', 'dark:text-white');
            document.getElementById('signInBtn').classList.remove('bg-blue-600', 'text-white');
        }

        function showSignIn() {
            document.getElementById('signUpForm').classList.add('hidden');
            document.getElementById('signInForm').classList.remove('hidden');
            document.getElementById('signUpBtn').classList.add('bg-gray-300', 'dark:bg-gray-700', 'dark:text-white');
            document.getElementById('signUpBtn').classList.remove('bg-blue-600', 'text-white');
            document.getElementById('signInBtn').classList.add('bg-blue-600', 'text-white');
            document.getElementById('signInBtn').classList.remove('bg-gray-300', 'dark:bg-gray-700', 'dark:text-white');
        }

        document.querySelectorAll('button[type="button"]').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>