<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - Complete Python Bootcamp - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 dark-transition bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text hover:scale-105 transition-transform">Youdemy</span>
                    </a>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex ml-10 space-x-8">
                        <a href="/" class="dark-transition text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">Home</a>
                        <a href="cource.php" class="dark-transition text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">Courses</a>
                        <a href="/learning" class="dark-transition text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">My Learning</a>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 items-center justify-center px-6">
                    <div class="w-full max-w-lg relative">
                        <input type="text" 
                               class="w-full dark-transition bg-gray-100 dark:bg-gray-700 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white"
                               placeholder="Search for courses...">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Right Navigation -->
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-moon dark:hidden text-gray-600"></i>
                        <i class="fas fa-sun hidden dark:block text-yellow-400"></i>
                    </button>

                    <!-- Notifications -->
                    <div class="relative">
                        <button class="dark-transition text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                            <i class="fas fa-bell"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                        </button>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative" id="profileDropdown">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <img src="/api/placeholder/32/32" alt="Profile" class="h-8 w-8 rounded-full ring-2 ring-blue-500">
                            <span class="hidden md:block dark-transition text-gray-700 dark:text-gray-200">John Doe</span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Course Hero Section (same as before) -->
    <div class="pt-20 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-800 dark:to-indigo-800">
        <!-- Previous hero content... -->
    </div>

    <!-- Course Content -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content Area -->
            <div class="lg:col-span-2">
                <!-- Tabs -->
                <div class="mb-8 border-b dark:border-gray-700">
                    <div class="flex space-x-8">
                        <button class="px-4 py-2 border-b-2 border-blue-600 text-blue-600 font-medium">Overview</button>
                        <button class="px-4 py-2 text-gray-600 dark:text-gray-300">Curriculum</button>
                        <button class="px-4 py-2 text-gray-600 dark:text-gray-300">Reviews</button>
                        <button class="px-4 py-2 text-gray-600 dark:text-gray-300">Instructor</button>
                    </div>
                </div>

                <!-- Course Description -->
                <div class="prose dark:prose-invert max-w-none">
                    <h2 class="text-2xl font-bold mb-4 dark:text-white">Course Description</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        Become a Python Programmer and learn one of employer's most requested skills! This is the most comprehensive, yet straight-forward, course for the Python programming language on Youdemy! Whether you have never programmed before, already know basic syntax, or want to learn about the advanced features of Python, this course is for you!
                    </p>

                    <h3 class="text-xl font-bold mb-3 dark:text-white">What you'll learn</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span class="text-gray-600 dark:text-gray-300">Learn Python from beginner to advanced</span>
                        </div>
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span class="text-gray-600 dark:text-gray-300">Build 5 real-world Python projects</span>
                        </div>
                        <!-- More learning points... -->
                    </div>

                    <!-- Course Curriculum -->
                    <h3 class="text-xl font-bold mb-4 dark:text-white">Course Content</h3>
                    <div class="space-y-4">
                        <!-- Section 1 -->
                        <div class="border dark:border-gray-700 rounded-lg overflow-hidden">
                            <button class="w-full px-6 py-4 flex items-center justify-between bg-gray-50 dark:bg-gray-800">
                                <div class="flex items-center space-x-4">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                    <span class="font-medium dark:text-white">Section 1: Introduction to Python</span>
                                </div>
                                <span class="text-sm text-gray-500">6 lectures • 45min</span>
                            </button>
                            <div class="p-6 bg-white dark:bg-gray-800 border-t dark:border-gray-700">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <i class="fas fa-play-circle text-gray-400"></i>
                                            <span class="text-gray-600 dark:text-gray-300">1. Welcome to the Course</span>
                                        </div>
                                        <span class="text-sm text-gray-500">5:30</span>
                                    </div>
                                    <!-- More lectures... -->
                                </div>
                            </div>
                        </div>
                        <!-- More sections... -->
                    </div>

                    <!-- Requirements -->
                    <h3 class="text-xl font-bold mt-8 mb-4 dark:text-white">Requirements</h3>
                    <ul class="list-disc pl-6 space-y-2 text-gray-600 dark:text-gray-300">
                        <li>No programming experience needed - I'll teach you everything you need to know</li>
                        <li>A computer with internet access and an enthusiasm to learn!</li>
                    </ul>
                </div>

                <!-- Reviews Section -->
                <div class="mt-12">
                    <h3 class="text-xl font-bold mb-6 dark:text-white">Student Reviews</h3>
                    <div class="space-y-6">
                        <!-- Review Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <img src="/api/placeholder/40/40" alt="Student" class="rounded-full">
                                    <div>
                                        <h4 class="font-medium dark:text-white">John Smith</h4>
                                        <div class="flex text-yellow-400">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">2 weeks ago</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300">
                                This course is absolutely fantastic! The instructor explains everything clearly and the projects really help reinforce the concepts. I went from knowing nothing about Python to building my own applications.
                            </p>
                        </div>
                        <!-- More review cards... -->
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm mt-6">
        <h4 class="font-medium mb-4 dark:text-white">Add Your Review</h4>
        <form id="review-form" class="space-y-4">
            <div>
                <label for="rating" class="block text-sm font-medium dark:text-gray-300">Rating</label>
                <div class="flex space-x-2">
                    <i class="fas fa-star text-gray-400 cursor-pointer hover:text-yellow-400" data-value="1"></i>
                    <i class="fas fa-star text-gray-400 cursor-pointer hover:text-yellow-400" data-value="2"></i>
                    <i class="fas fa-star text-gray-400 cursor-pointer hover:text-yellow-400" data-value="3"></i>
                    <i class="fas fa-star text-gray-400 cursor-pointer hover:text-yellow-400" data-value="4"></i>
                    <i class="fas fa-star text-gray-400 cursor-pointer hover:text-yellow-400" data-value="5"></i>
                </div>
                <input type="hidden" id="rating" name="rating" value="0">
            </div>
            <div>
                <label for="comment" class="block text-sm font-medium dark:text-gray-300">Comment</label>
                <textarea id="comment" name="comment" rows="4" class="w-full p-3 border dark:border-gray-700 rounded-lg dark:bg-gray-900 dark:text-gray-300" placeholder="Write your review..."></textarea>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Submit Review</button>
        </form>
    </div>

            </div>
             
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <!-- Share Course -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm mb-6">
                        <h3 class="font-medium mb-4 dark:text-white">Share this course</h3>
                        <div class="flex space-x-4">
                            <button class="p-2 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="p-2 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="p-2 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Similar Courses -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                        <h3 class="font-medium mb-4 dark:text-white">Similar Courses</h3>
                        <div class="space-y-4">
                            <div class="flex space-x-4">
                                <img src="/api/placeholder/80/60" alt="Course" class="rounded-lg w-20 h-15 object-cover">
                                <div>
                                    <h4 class="font-medium dark:text-white">Advanced Python Programming</h4>
                                    <div class="flex text-yellow-400 text-sm">
                                        <i class="fas fa-star"></i>
                                        <span class="ml-1 text-gray-600 dark:text-gray-300">4.8</span>
                                    </div>
                                    <span class="text-blue-600">$94.99</span>
                                </div>
                            </div>
                            <!-- More similar courses... -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        // Add toggle functionality for curriculum sections
        document.querySelectorAll('.curriculum-section').forEach(section => {
            section.querySelector('button').addEventListener('click', () => {
                section.querySelector('.section-content').classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>