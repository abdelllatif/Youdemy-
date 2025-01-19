<?php
session_start();
require_once '../../Classes/class_course_content.php';

if (isset($_GET['iddoc'])) {
    $id = intval($_GET['iddoc']);

    $document = new VideoHandler();
    $vedio = $document->afficherbyid($id);


    if (is_array($vedio) && count($vedio) > 0) {
        $vedio = $vedio;
        if (isset($vedio['title'], $vedio['video_path'], $vedio['description'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dark-transition {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .playlist {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
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

    <!-- Hero Section -->
    <div class="pt-20 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-800 dark:to-indigo-800">
        <div class="max-w-7xl mx-auto px-4 py-12 text-center">
            <h1 class="text-4xl font-bold text-white"><?= htmlspecialchars($vedio['title']) ?></h1>
            <p class="mt-4 text-lg text-indigo-200">Learn Python from scratch and build your own projects</p>
        </div>
    </div>
    <!-- Course Content -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Video and Playlist Section -->
            <div class="lg:col-span-2">
                <!-- Video Section -->
                <div class="mb-8">
                    <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden">
                        <video id="course-video" controls class="w-full h-full object-cover">
                            <source src="../../professor/Backend/<?= htmlspecialchars($vedio['video_path']) ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <?= htmlspecialchars($vedio['video_path']) ?> 
            </div>

        </div>

        <!-- Instructor Info Section -->
        <div class="w-full bg-white dark:bg-gray-800 rounded-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-200 dark:border-gray-700 pb-6">
                <!-- Left side - Instructor info -->
                <div class="flex items-center space-x-4">
                    <img src="../../<?= htmlspecialchars($vedio['avatar_path'])?>" alt="Dr. Sarah Johnson" class="rounded-full w-16 h-16 object-cover">
                    <div>
                    <h3 class="text-xl font-bold dark:text-white"> Dr. <?= htmlspecialchars($vedio['first_name']) . " " . htmlspecialchars($vedio['last_name']) ?></h3>
                        <p class="text-gray-600 dark:text-gray-300">Python Expert & Senior Developer</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <i class="fas fa-users text-gray-500"></i>
                            <span class="text-sm text-gray-500">234,567 followers</span>
                        </div>
                    </div>
                </div>

                <!-- Right side - Like button and form -->
                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                    <form id="like-form" class="flex items-center">
                        <input type="hidden" name="course_id" value="python_bootcamp_101">
                        <input type="hidden" name="liked" value="0" id="liked-input">
                        <button type="button" id="like-button" class="flex items-center space-x-2 px-4 py-2 rounded-full border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-thumbs-up text-gray-500" id="like-icon"></i>
                            <span class="font-medium text-gray-700 dark:text-gray-300" id="like-text">Like</span>
                        </button>
                    </form>
                    <button id="follow-button" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                        Follow
                    </button>
                </div>
            </div>
        </div>
      
        <!-- Course Description -->
        <div class="mt-12">
            <div class="prose dark:prose-invert max-w-none mb-8">
                <h2 class="text-2xl font-bold mb-4 dark:text-white">Course Description</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-6"><?= htmlspecialchars($vedio['description']) ?></p>

                <h3 class="text-xl font-bold mb-3 dark:text-white">What you'll learn</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-start space-x-2">
                    <?php foreach ($vedio['learning'] as $objective): ?>
                      <i class="fas fa-check text-green-500 mt-1"></i>
                      <span class="text-gray-600 dark:text-gray-300"><?= htmlspecialchars($objective); ?></span>
                  <?php endforeach; ?>
                    </div>
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

            <!-- Add Review Section -->
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

        function changeVideo(videoSrc) {
            const video = document.getElementById('course-video');
            video.src = videoSrc;
            video.play();
        }
        // Rating stars click event
        document.querySelectorAll('#review-form .fa-star').forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                document.getElementById('rating').value = value;
                document.querySelectorAll('#review-form .fa-star').forEach(s => {
                    s.classList.remove('text-yellow-400');
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('text-yellow-400');
                    }
                });
            });
        });

        // Like button click event
        const likeButton = document.getElementById('like-button');
        const likeIcon = document.getElementById('like-icon');
        const likeText = document.getElementById('like-text');
        const likedInput = document.getElementById('liked-input');
        let isLiked = false;

        likeButton.addEventListener('click', function() {
            isLiked = !isLiked;
            
            if (isLiked) {
                    likeIcon.classList.remove('text-gray-500');
                    likeIcon.classList.add('text-blue-500');
                    likeText.textContent = 'Liked';
                    likeText.classList.remove('text-gray-700', 'dark:text-gray-300');
                    likeText.classList.add('text-blue-500');
                    likedInput.value = '1';
                } else {
                    likeIcon.classList.remove('text-blue-500');
                    likeIcon.classList.add('text-gray-500');
                    likeText.textContent = 'Like';
                    likeText.classList.remove('text-blue-500');
                    likeText.classList.add('text-gray-700', 'dark:text-gray-300');
                    likedInput.value = '0';
                }
            });
            </script>
</body>
</html>

<?php 
        } else {
            echo "The video data does not contain the expected keys.";
        }
    } else {
        echo "No video data found or the data structure is incorrect.";
    }
}
?>