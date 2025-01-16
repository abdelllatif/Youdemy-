<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Previous styles remain the same */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
  <!-- Navigation -->
  <nav class="fixed w-full z-50 dark-transition bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <a href="../../index.php" class="flex items-center space-x-2">
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text hover:scale-105 transition-transform">Youdemy</span>
                    </a>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex ml-10 space-x-8">
                        <a href="../../index.php" class="dark-transition text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">Home</a>
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

    <main class="pt-20">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Profile Header -->
            <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row items-center md:items-start">
                    <div class="mb-4 md:mb-0 md:mr-6">
                        <img src="/api/placeholder/128/128" alt="Profile" class="rounded-full w-32 h-32">
                        <button id="changePhotoBtn" class="mt-2 text-blue-400 text-sm hover:text-blue-300">Change Photo</button>
                    </div>
                    <div class="text-center md:text-left flex-grow">
                        <h1 class="text-2xl font-bold mb-2">John Doe</h1>
                        <p class="text-gray-400 mb-4">Web Development Student</p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4">
                            <div>
                                <i class="fas fa-book-reader mr-2"></i>
                                <span>5 Courses</span>
                            </div>
                            <div>
                                <i class="fas fa-certificate mr-2"></i>
                                <span>3 Certificates</span>
                            </div>
                            <div>
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>Age: 25</span>
                            </div>
                        </div>
                    </div>
                    <button class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Edit Profile</button>
                </div>
            </div>

            <!-- Enhanced Dashboard Tabs -->
            <div class="mb-8">
                <div class="border-b border-gray-700">
                    <nav class="flex flex-wrap gap-4">
                        <button id="myCoursesTab" class="border-b-2 border-blue-600 py-4 px-1 text-blue-400 font-medium">My Courses</button>
                        <button id="savedCoursesTab" class="border-b-2 border-transparent py-4 px-1 text-gray-500 hover:text-gray-300 font-medium">Saved Courses</button>
                        <button id="catalogTab" class="border-b-2 border-transparent py-4 px-1 text-gray-500 hover:text-gray-300 font-medium">Course Catalog</button>
                        <button id="commentsTab" class="border-b-2 border-transparent py-4 px-1 text-gray-500 hover:text-gray-300 font-medium">My Comments</button>
                        <button id="certificatesTab" class="border-b-2 border-transparent py-4 px-1 text-gray-500 hover:text-gray-300 font-medium">Certificates</button>
                    </nav>
                </div>
            </div>

            <!-- Content Section -->
            <div id="contentSection" class="space-y-6">
                <!-- Content will be dynamically loaded here -->
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 border-t border-gray-700 mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; 2025 Youdemy, Inc. All rights reserved.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-gray-200"><i class="fab fa-facebook-square"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-200"><i class="fab fa-twitter-square"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-200"><i class="fab fa-instagram-square"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // Enhanced JavaScript for tab switching and content loading
        const tabs = {
            'myCoursesTab': function() {
                return `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Active Course Card -->
                        <div class="course-card bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <img src="/api/placeholder/320/180" alt="Web Development" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold mb-2">Complete Web Development Bootcamp</h3>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-300">by Jane Smith</span>
                                    <span class="text-sm font-medium text-green-400">75% Complete</span>
                                </div>
                                <div class="w-full bg-gray-600 rounded-full h-2 mb-4">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                                <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Continue Learning</button>
                            </div>
                        </div>
                        <!-- Add more course cards as needed -->
                    </div>
                `;
            },
            'savedCoursesTab': function() {
                return `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Saved Course Card -->
                        <div class="course-card bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <img src="/api/placeholder/320/180" alt="AI Course" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold mb-2">Artificial Intelligence Fundamentals</h3>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-300">by John Johnson</span>
                                    <span class="text-sm text-blue-400">$89.99</span>
                                </div>
                                <div class="flex space-x-2 mb-4">
                                    <span class="px-2 py-1 bg-gray-700 rounded-full text-xs">AI</span>
                                    <span class="px-2 py-1 bg-gray-700 rounded-full text-xs">Machine Learning</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="flex-1 bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Enroll Now</button>
                                    <button class="p-2 bg-red-600 text-white rounded hover:bg-red-500">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            },
            'catalogTab': function() {
                return `
                    <div class="mb-6">
                        <div class="flex space-x-4 mb-6">
                            <select class="bg-gray-700 rounded px-4 py-2">
                                <option>All Categories</option>
                                <option>Development</option>
                                <option>Business</option>
                                <option>Design</option>
                            </select>
                            <select class="bg-gray-700 rounded px-4 py-2">
                                <option>Price Range</option>
                                <option>Free</option>
                                <option>Paid</option>
                            </select>
                            <select class="bg-gray-700 rounded px-4 py-2">
                                <option>Level</option>
                                <option>Beginner</option>
                                <option>Intermediate</option>
                                <option>Advanced</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Catalog Course Card -->
                            <div class="course-card bg-gray-800 rounded-lg shadow-md overflow-hidden">
                                <img src="/api/placeholder/320/180" alt="Python Course" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold">Python for Data Science</h3>
                                        <button class="text-gray-400 hover:text-blue-400">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-400 mb-2">Learn Python for data analysis and visualization</p>
                                    <div class="flex items-center mb-2">
                                        <img src="/api/placeholder/24/24" alt="Instructor" class="w-6 h-6 rounded-full mr-2">
                                        <span class="text-sm text-gray-300">Sarah Williams</span>
                                    </div>
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                                            <span class="text-sm">4.8 (2.5k reviews)</span>
                                        </div>
                                        <span class="text-lg font-bold">$69.99</span>
                                    </div>
                                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Enroll Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            },
            'commentsTab': function() {
                return `
                    <div class="space-y-6">
                        <div class="bg-gray-800 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-semibold">My Comments & Reviews</h3>
                                <select class="bg-gray-700 rounded px-4 py-2">
                                    <option>Most Recent</option>
                                    <option>Oldest First</option>
                                </select>
                            </div>
                            <!-- Comment Card -->
                            <div class="space-y-4">
                                <div class="border-b border-gray-700 pb-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-medium">Complete Web Development Bootcamp</h4>
                                            <div class="flex items-center">
                                                <div class="flex text-yellow-400">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                </div>
                                                <span class="text-sm text-gray-400 ml-2">Posted 2 days ago</span>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button class="text-blue-400 hover:text-blue-300">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-red-400 hover:text-red-300">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-gray-300">Great course! The instructor explains everything clearly and provides practical examples.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            },
            'certificatesTab': function() {
                return `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden p-4">
                            <h3 class="font-semibold mb-2">Web Development Certificate</h3>
                            <p class="text-sm text-gray-300 mb-2">Issued by Youdemy</p>
                            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">View Certificate</button>
                        </div>
                    </div>
                `;
            }
        };

        // Function to handle tab switching
        function switchTab(tabId) {
            // Remove active state from all tabs
            document.querySelectorAll('nav button').forEach(button => {
                button.classList.remove('border-blue-600', 'text-blue-400');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Add active state to clicked tab
            document.getElementById(tabId).classList.remove('border-transparent', 'text-gray-500');
            document.getElementById(tabId).classList.add('border-blue-600', 'text-blue-400');

            // Load content
            document.getElementById('contentSection').innerHTML = tabs[tabId]();
        }

        // Add click handlers to all tabs
        Object.keys(tabs).forEach(tabId => {
            document.getElementById(tabId).addEventListener('click', () => switchTab(tabId));
        });

        // Load My Courses content by default
        switchTab('myCoursesTab');
    </script>
</body>
</html>