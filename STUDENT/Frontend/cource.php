<?php 
require_once '../Backend/test.php';
require_once '../Backend/vedio.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Catalog - Youdemy</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .view-toggle-btn.active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <!-- Navbar remains the same -->
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
                        <a href="index.php" class="dark-transition text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">Home</a>
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

    <!-- Main Content with top margin to account for fixed navbar -->
    <div class="pt-16">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Search and Filters -->
            <div class="mb-8">
                <div class="relative">
                    <input type="text" 
                        id="searchInput"
                        placeholder="Search courses..." 
                        class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-800 dark:text-white dark:border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute right-3 top-3.5 text-gray-400"></i>
                </div>
                <div class="flex flex-wrap gap-4 mt-4">
                    <button class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">All</button>
                    <button class="px-4 py-2 rounded-lg border dark:border-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Programming</button>
                    <button class="px-4 py-2 rounded-lg border dark:border-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Design</button>
                    <button class="px-4 py-2 rounded-lg border dark:border-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Business</button>
                    <button class="px-4 py-2 rounded-lg border dark:border-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Marketing</button>
                </div>
            </div>

           <!-- Results Summary -->
           <div class="flex justify-between items-center mb-6">
            <p class="text-gray-600 dark:text-gray-300">Showing <span class="font-semibold">1-9</span> of <span class="font-semibold">256</span> courses</p>
            <div class="flex items-center space-x-2">
                <label class="text-gray-600 dark:text-gray-300">View:</label>
                <button onclick="toggleView('video')" id="videoViewBtn" class="view-toggle-btn px-3 py-2 rounded-lg border dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 active">Video</button>
                <button onclick="toggleView('document')" id="documentViewBtn" class="view-toggle-btn px-3 py-2 rounded-lg border dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Documents</button>
            </div>
            <div class="flex items-center space-x-2">
                <label class="text-gray-600 dark:text-gray-300">Sort by:</label>
                <select class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-300">
                    <option>Most Popular</option>
                    <option>Newest First</option>
                    <option>Highest Rated</option>
                </select>
            </div>
        </div>
        
         <!-- Course Grid for Video view-->
         <div id="courseGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($videos as $video): ?>
        <article class="course-card bg-gray-800 rounded-xl overflow-hidden">
            <div class="relative">
                <!-- Thumbnail -->
                <img src="../../professor/Backend/<?= htmlspecialchars($video['thumbnail_path']); ?>" alt="Video Thumbnail" class="w-full h-48 object-cover">
                <!-- Duration -->
                <span class="absolute bottom-2 right-2 bg-black bg-opacity-75 text-white px-2 py-1 rounded">
                    <?= sprintf("%02d:%02d:%02d", floor($video['duration'] / 3600), floor(($video['duration'] % 3600) / 60), $video['duration'] % 60); ?>
                </span>
            </div>
            <div class="p-4">
                <!-- Title -->
                <h3 class="text-lg font-semibold mb-2 text-white"><?= htmlspecialchars($video['title']); ?></h3>
                
                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mb-2">
                    <span class="bg-blue-600 text-xs px-2 py-1 rounded"><?= htmlspecialchars($video['category'] ?? 'Category'); ?></span>
                    <span class="bg-purple-600 text-xs px-2 py-1 rounded"><?= htmlspecialchars($video['level'] ?? 'Level'); ?></span>
                </div>
                
                <!-- Teacher Information -->
                <div class="flex items-center mb-2">
                    <img src="../../<?= htmlspecialchars($video['avatar_path']); ?>" alt="Teacher Avatar" class="w-8 h-8 rounded-full mr-2">
                    <span class="text-sm text-gray-400"><?= htmlspecialchars($video['first_name'] . ' ' . $video['last_name']); ?> - <?= htmlspecialchars(ucfirst($video['role'])); ?></span>
                </div>
                
                <!-- Ratings -->
                <div class="flex items-center mb-2">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="ml-1 text-sm text-gray-300"><?= htmlspecialchars($video['rating'] ?? 'N/A'); ?></span>
                    <span class="mx-2 text-gray-400">|</span>
                    <span class="text-sm text-gray-400"><?= htmlspecialchars(number_format($video['students'] ?? 0)); ?> students</span>
                </div>
                
                <!-- Learning Objectives -->
                <div class="mb-2">
                    <h4 class="text-sm font-medium text-gray-400">Learning Objectives:</h4>
                    <ul class="text-sm text-gray-300 list-disc list-inside">
                        <li><?= htmlspecialchars($video['objective_1'] ?? 'Objective 1'); ?></li>
                        <li><?= htmlspecialchars($video['objective_2'] ?? 'Objective 2'); ?></li>
                    </ul>
                </div>
                <form action="vedio.php" method="POST">
    <input name="idved" type="hidden" value="<?php echo htmlspecialchars($video['id']); ?>">
    <button type="submit" class="text-blue-400 text-sm hover:text-blue-300">View Details →</button>
</form>
            </div>
        </article>
    <?php endforeach; ?>
</div>
    </div>
    
  <!-- Document Grid -->
<div id="documentsContent" class="grid grid-cols-1 hidden sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    <?php foreach ($result as $resul): ?>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:scale-105 transition duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <?php
                    $filePath = $resul['document_path'] ?? '';
                    $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    ?>
                    <?php if ($fileExtension === 'pdf'): ?>
                        <i class="fas fa-file-pdf text-4xl text-red-500"></i>
                    <?php elseif (in_array($fileExtension, ['xls', 'xlsx'])): ?>
                        <i class="fas fa-file-excel text-4xl text-green-500"></i>
                    <?php else: ?>
                        <i class="fas fa-file text-4xl text-blue-500"></i>
                    <?php endif; ?>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white truncate">
                            <?= htmlspecialchars($resul['title']); ?>
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <?= htmlspecialchars($resul['first_name'] . ' ' . $resul['last_name']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Document Description -->
            <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                <?= htmlspecialchars($resul['description']); ?>
            </p>

            <!-- Document Details -->
            <div class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                <p class="flex items-center">
                    <i class="fas fa-calendar-alt w-5 text-gray-400 dark:text-gray-500"></i>
                    <span>Created: <?= date('M d, Y', strtotime($resul['created_at'])); ?></span>
                </p>
                <?php if (!empty($resul['updated_at'])): ?>
                <p class="flex items-center">
                    <i class="fas fa-clock w-5 text-gray-400 dark:text-gray-500"></i>
                    <span>Updated: <?= date('M d, Y', strtotime($resul['updated_at'])); ?></span>
                </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Document Footer -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img class="rounded-full w-10 h-10" src="../../<?= htmlspecialchars($resul['avatar_path']); ?>" alt="">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    <i class="fas fa-user-shield"></i>
                    <?= htmlspecialchars(ucfirst($resul['role'])); ?>
                </span>
            </div>

            <div class="flex space-x-2">
                <!-- View Button -->
                <a href="<?= htmlspecialchars($resul['document_path']); ?>" target="_blank" 
                   class="px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-lg hover:bg-green-600 focus:ring-2 focus:ring-green-300 transition">
                    <i class="fas fa-eye"></i>
                </a>

                <!-- Download Button -->
                <a href="<?= htmlspecialchars($resul['document_path']); ?>" download
                   class="px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 transition">
                    <i class="fas fa-download"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>


        


            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <button class="p-2 rounded-lg border dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 disabled:opacity-50">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-4 py-2 rounded-lg bg-blue-600 text-white">1</button>
                    <button class="px-4 py-2 rounded-lg border dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">2</button>
                    <button class="px-4 py-2 rounded-lg border dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">3</button>
                    <span class="px-4 py-2 text-gray-600 dark:text-gray-400">...</span>
                    <button class="px-4 py-2 rounded-lg border dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">12</button>
                    <button class="p-2 rounded-lg border dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </nav>
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
                <p class="text-center text-gray-400">© 2024 Youdemy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        let currentView = 'video';

        function toggleView(view) {
            currentView = view;

            const courseGrid = document.getElementById('courseGrid');
            const documentsContent = document.getElementById('documentsContent');
            const videoViewBtn = document.getElementById('videoViewBtn');
            const documentViewBtn = document.getElementById('documentViewBtn');


            if (currentView === 'video') {
                courseGrid.classList.remove('hidden');
                documentsContent.classList.add('hidden');
                videoViewBtn.classList.add('active');
                documentViewBtn.classList.remove('active');
            } else if (currentView === 'document') {
                courseGrid.classList.add('hidden');
                documentsContent.classList.remove('hidden');
                videoViewBtn.classList.remove('active');
                documentViewBtn.classList.add('active');
            }
        }
       function toggleDarkMode() {
            document.body.classList.toggle('dark');
        }
    </script>
</body>
</html>