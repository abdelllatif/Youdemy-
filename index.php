<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Modern Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }

        /* Custom Styles */
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }

        .dark .glass-effect {
            background: rgba(0, 0, 0, 0.2);
        }

        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Dark mode transitions */
        .dark-transition {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>
<body class="dark-transition bg-gray-50 dark:bg-gray-900" x-data="{ darkMode: false, mobileMenuOpen: false }">
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
                        <a href="STUDENT/Frontend/cource.php" class="dark-transition text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">Courses</a>
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
    <?php if (!isset($_SESSION['client'])): ?>
        <a href="login/frontend/singin.php" class="text-blue-500 hover:underline">Connexion</a>
    <?php else: ?>
        <div class="relative" id="profileDropdown">
            <button class="flex items-center space-x-2 focus:outline-none">
                <img src="/api/placeholder/32/32" alt="Profile" class="h-8 w-8 rounded-full ring-2 ring-blue-500">
                <span class="hidden md:block dark-transition text-gray-700 dark:text-gray-200">
                    <?= htmlspecialchars($_SESSION['client']['first_name'] ?? 'Utilisateur') ?>
                </span>
                <i class="fas fa-chevron-down text-gray-400"></i>
            </button>
        </div>
    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        <!-- Hero Section -->
        <div class="relative h-screen bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-800 dark:to-indigo-800 overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop class="absolute inset-0 w-full h-full object-cover opacity-50">
        <source src="https://cdn.pixabay.com/video/2024/06/06/215470_large.mp4" type="video/mp4">
    </video>

    <!-- Overlay Pattern -->
    <div class="absolute inset-0 bg-pattern opacity-10"></div>

    <!-- Content -->
    <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="animate-fade-in text-4xl font-extrabold text-white sm:text-5xl md:text-6xl">
                Unlock Your Potential
                <span class="block text-blue-200">Learn Without Limits</span>
            </h1>
            <p class="animate-fade-in mt-6 max-w-2xl mx-auto text-xl text-blue-100">
                Join millions of learners worldwide and transform your career with expert-led courses.
            </p>
            <div class="animate-fade-in mt-10 flex justify-center space-x-4">
                <a href="/courses" class="inline-flex items-center px-6 py-3 rounded-lg bg-white text-blue-600 hover:bg-gray-100 transition-colors duration-300">
                    <span>Start Learning</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <a href="/teach" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-white text-white hover:bg-white hover:text-blue-600 transition-colors duration-300">
                    Become an Instructor
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Featured Categories -->
<div class="max-w-7xl mx-auto py-12 px-4">
    <h2 class="text-2xl font-bold dark-transition text-gray-900 dark:text-white mb-8">Top Categories</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Category Cards -->
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6 text-center cursor-pointer">
            <div class="rounded-full bg-green-100 dark:bg-green-900 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-flask text-2xl text-green-600 dark:text-green-400"></i>
            </div>
            <h3 class="font-semibold dark-transition text-gray-900 dark:text-white">Science</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">850+ courses</p>
        </div>
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6 text-center cursor-pointer">
            <div class="rounded-full bg-yellow-100 dark:bg-yellow-900 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-calculator text-2xl text-yellow-600 dark:text-yellow-400"></i>
            </div>
            <h3 class="font-semibold dark-transition text-gray-900 dark:text-white">Mathematics</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">500+ courses</p>
        </div>
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6 text-center cursor-pointer">
            <div class="rounded-full bg-purple-100 dark:bg-purple-900 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-paint-brush text-2xl text-purple-600 dark:text-purple-400"></i>
            </div>
            <h3 class="font-semibold dark-transition text-gray-900 dark:text-white">Arts & Design</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">400+ courses</p>
        </div>
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6 text-center cursor-pointer">
            <div class="rounded-full bg-red-100 dark:bg-red-900 w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-globe text-2xl text-red-600 dark:text-red-400"></i>
            </div>
            <h3 class="font-semibold dark-transition text-gray-900 dark:text-white">Languages</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">750+ courses</p>
        </div>
    </div>
</div>

<!-- Featured Courses -->
<div class="max-w-7xl mx-auto py-12 px-4">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold dark-transition text-gray-900 dark:text-white">Featured Courses</h2>
        <a href="/courses" class="text-blue-600 dark:text-blue-400 hover:underline">View All</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Course Card Example -->
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
            <img src="https://i.pinimg.com/736x/41/f7/c2/41f7c2d6fcdb4d04f0f05b9b675a8c6a.jpg" alt="Course Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
            <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">Basics of Quantum Physics</h3>
            <div class="flex items-center mb-2">
                <img src="https://www.sapaviva.com/wp-content/uploads/2017/06/9S.-Marie-Curie-1867-1934-1-1918x1918.jpg" alt="Creator" class="w-8 h-8 rounded-full mr-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">by Dr. Marie Curie</span>
            </div>
            <div class="flex items-center mb-2">
                    <!-- Star Rating -->
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Last updated: 2025-01-05</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">30 videos</p>
        </div>
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
            <img src="https://media.licdn.com/dms/image/v2/D4D12AQHBRJhvIvL5QA/article-cover_image-shrink_720_1280/article-cover_image-shrink_720_1280/0/1721179052009?e=2147483647&v=beta&t=P6SewZ_urLxkD2wqvAXzI7pRuq7g4zbXn7aeclV-ZN8" alt="Course Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
            <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">Mastering Algebra</h3>
            <div class="flex items-center mb-2">
                <img src="https://i.pinimg.com/736x/5b/c7/58/5bc7580160e1d64115810d180aa1bfbc.jpg" alt="Creator" class="w-8 h-8 rounded-full mr-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">by Alan Edelman </span>
            </div>
            <div class="flex items-center mb-2">
                    <!-- Star Rating -->
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Last updated: 2025-01-03</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">50 videos</p>
        </div>
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
            <img src="https://nexacu.com/media/p4ydfxqm/illustration-of-streamlined-workflow-with-adobe-illustrator-tools.jpg" alt="Course Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
            <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">Illustration with Adobe Illustrator</h3>
            <div class="flex items-center mb-2">
                <img src="https://yt3.googleusercontent.com/GJejalNPLMeFgKmPhxJ9cx5Q8_ESmceiPN8_YjXLUtfD1gy9J81S5Gatt7sUbpU_jSs-fgzZjA=s160-c-k-c0x00ffffff-no-rj" alt="Creator" class="w-8 h-8 rounded-full mr-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">by Andy Tells Things</span>
            </div>
            <div class="flex items-center mb-2">
                    <!-- Star Rating -->
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Last updated: 2025-01-04</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">40 videos</p>
        </div>
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
            <img src="https://cdn.buttercms.com/t349DUJUReydclxkbGiA" alt="Course Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
            <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">Python Essentials</h3>
            <div class="flex items-center mb-2">
                <img src="https://gvanrossum.github.io/images/guido-headshot-2019.jpg" alt="Creator" class="w-8 h-8 rounded-full mr-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">by Guido van Rossum</span>
            </div>
            <div class="flex items-center mb-2">
                    <!-- Star Rating -->
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Last updated: 2025-01-01</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">45 videos</p>
        </div>
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
            <img src="https://i.ytimg.com/vi/_UEdm9GLDkk/maxresdefault.jpg" alt="Course Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
            <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">Web Design for Beginners</h3>
            <div class="flex items-center mb-2">
                <img src="https://yt3.googleusercontent.com/YhKL_HNwoDofviNS13Sp_QjQGQy0mOwp4G9CWED26v55GsoYLaA6adCbhb00Sx0621sLkkIA=s160-c-k-c0x00ffffff-no-rj" alt="Creator" class="w-8 h-8 rounded-full mr-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">by Jesse Showalter</span>
            </div>
            <div class="flex items-center mb-2">
                    <!-- Star Rating -->
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Last updated: 2025-01-10</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">30 videos</p>
        </div>
        <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
                <img src="https://i.ytimg.com/vi/RjfZrcAMH5E/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBzTHSv7xF0Bmjkyzl7BWdv0D1m7Q" alt="Course Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">Mastering Data Analysis with Excel</h3>
                <div class="flex items-center mb-2">
                    <img src="https://yt3.googleusercontent.com/9ZZjWRnwsec7xVsT1Uu67UEhqNt5KYW5hjbr8pw3msp5C6LCUGuEuBx-LhDyf5QwWKkAwz2ktg=s160-c-k-c0x00ffffff-no-rj" alt="Creator" class="w-8 h-8 rounded-full mr-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">by Kenji Explains</span>
                </div>
                <div class="flex items-center mb-2">
                    <!-- Star Rating -->
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                    <i class="fas fa-star text-gray-300 dark:text-gray-600"></i>
                </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Last updated: 2025-01-08</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400"> video</p>
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
            // Dark Mode Toggle
            function toggleDarkMode() {
                document.documentElement.classList.toggle('dark');
                const isDark = document.documentElement.classList.contains('dark');
                localStorage.setItem('darkMode', isDark);
            }

            // Check for saved dark mode preference
            if (localStorage.getItem('darkMode') === 'true' || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches && 
                !localStorage.getItem('darkMode'))) {
                document.documentElement.classList.add('dark');
            }

            // Profile Dropdown
            const profileDropdown = document.getElementById('profileDropdown');
            profileDropdown.addEventListener('click', () => {
                const menu = document.createElement('div');
                menu.className = 'absolute right-0 mt-2 w-48 rounded-lg shadow-lg dark-transition bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 animate-fade-in';
                menu.innerHTML = `
                    <div class="py-1">
                    <a href="professor/Frontend/teacher.php" class="dark-transition block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">teacher</a>
                    <a href="STUDENT/Frontend/profile.php" class="dark-transition block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                    <a href="/settings" class="dark-transition block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
                    <a href="Login/frontend/logout.php" class="dark-transition block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
                        </div>
                `;
                
                const existingMenu = document.querySelector('#profileMenu');
                if (existingMenu) {
                    existingMenu.remove();
                } else {
                    menu.id = 'profileMenu';
                    profileDropdown.appendChild(menu);
                }
            });

            // Featured Courses Data
            const featuredCoursesData = [
                {
                    title: 'Complete Web Development 2024',
                    instructor: 'Jane Smith',
                    rating: 4.8,
                    students: 12500,
                    price: 89.99,
                    image: '/api/placeholder/320/180',
                    tags: ['Programming', 'Web Development']
                },
                // Add more courses...
            ];

            // Render Featured Courses
            const featuredCoursesContainer = document.getElementById('featuredCourses');
            featuredCoursesData.forEach(course => {
                const courseCard = document.createElement('div');
                courseCard.className = 'course-card dark-transition bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg';
                courseCard.innerHTML = `
                    <img src="${course.image}" alt="${course.title}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-3">
                            ${course.tags.map(tag => `
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">${tag}</span>
                            `).join('')}
                        </div>
                        <h3 class="text-lg font-semibold dark-transition text-gray-900 dark:text-white mb-2">${course.title}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">by ${course.instructor}</p>
                        <div class="flex items-center mb-2">
                            <div class="text-yellow-400 mr-1">${'★'.repeat(Math.floor(course.rating))}</div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">${course.rating} (${course.students.toLocaleString()} students)</span>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-lg font-bold dark-transition text-gray-900 dark:text-white">$${course.price}</span>
                            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                                Enroll Now
                            </button>
                        </div>
                    </div>
                `;
                featuredCoursesContainer.appendChild(courseCard);
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!profileDropdown.contains(e.target)) {
                    const menu = document.querySelector('#profileMenu');
                    if (menu) menu.remove();
                }
            });
            
        </script>
</body>
</html>