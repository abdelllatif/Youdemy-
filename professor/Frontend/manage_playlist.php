<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Manage Playlist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .modal {
            display: none;
        }

        .modal.show {
            display: flex;
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

    <main class="pt-20">
        
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Playlist Header -->
            <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-2xl font-bold mb-2">Web Design for Beginners</h1>
                <p class="text-gray-400 mb-4">A comprehensive guide to web design for absolute beginners.</p>
                <button id="postPlaylistBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">Post Playlist</button>
            </div>

            <!-- Videos Section -->
            <div id="playlist" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Example Video Cards -->
                <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
                    <img src="https://i.ytimg.com/vi/_UEdm9GLDkk/maxresdefault.jpg" alt="Video Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">Introduction to Web Design</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Duration: 10:30</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Edit Video</button>
                </div>
                <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
                    <img src="https://i.ytimg.com/vi/1Rs2ND1ryYc/maxresdefault.jpg" alt="Video Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">HTML Basics</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Duration: 15:45</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Edit Video</button>
                </div>
                <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
                    <img src="https://i.ytimg.com/vi/pQN-pnXPaVg/maxresdefault.jpg" alt="Video Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">CSS Fundamentals</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Duration: 20:10</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Edit Video</button>
                </div>
                <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
                    <img src="https://i.ytimg.com/vi/3JluqTojuME/maxresdefault.jpg" alt="Video Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">JavaScript Basics</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Duration: 25:00</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Edit Video</button>
                </div>
                <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
                    <img src="https://i.ytimg.com/vi/hdI2bqOjy3c/maxresdefault.jpg" alt="Video Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">Responsive Web Design</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Duration: 30:20</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Edit Video</button>
                </div>
                <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
                    <img src="https://i.ytimg.com/vi/PkZNo7MFNFg/maxresdefault.jpg" alt="Video Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">JavaScript ES6</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Duration: 22:45</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Edit Video</button>
                </div>
                <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
                    <img src="https://i.ytimg.com/vi/9cKsq14Kfsw/maxresdefault.jpg" alt="Video Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">CSS Grid Layout</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Duration: 18:00</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Edit Video</button>
                </div>
                <div class="course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6">
                    <img src="https://i.ytimg.com/vi/88PXJAA6szs/maxresdefault.jpg" alt="Video Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">Flexbox Tutorial</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Duration: 12:50</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Edit Video</button>
                </div>
            </div>

            <!-- Add New Video Button -->
            <div class="mt-8">
                <button id="addNewVideoBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Add New Video</button>
            </div>
            
            <!-- Add New Video Modal -->
            <div id="addVideoModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75">
                <div class="modal-content bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-white">Add New Video</h2>
                    <form id="addVideoForm">
                        <div class="mb-4">
                            <label for="videoTitle" class="block text-gray-300">Video Title</label>
                            <input type="text" id="videoTitle" name="videoTitle" class="mt-1 block w-full p-2 bg-gray-700 text-white rounded" placeholder="Enter video title" required>
                        </div>
                        <div class="mb-4">
                            <label for="videoThumbnail" class="block text-gray-300">Video Thumbnail</label>
                            <input type="file" id="videoThumbnail" name="videoThumbnail" class="mt-1 block w-full p-2 bg-gray-700 text-white rounded" accept="image/*" required>
                        </div>
                        <div class="mb-4">
                            <label for="videoFile" class="block text-gray-300">Video File</label>
                            <input type="file" id="videoFile" name="videoFile" class="mt-1 block w-full p-2 bg-gray-700 text-white rounded" accept="video/*" required>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" id="closeVideoModalBtn" class="mr-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Add Video</button>
                        </div>
                    </form>
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
        // Show the Add New Video modal when the button is clicked
        document.getElementById('addNewVideoBtn').addEventListener('click', function() {
            document.getElementById('addVideoModal').classList.add('show');
        });

        // Close the Add New Video modal when the Cancel button is clicked
        document.getElementById('closeVideoModalBtn').addEventListener('click', function() {
            document.getElementById('addVideoModal').classList.remove('show');
        });

        // Handle Add New Video form submission
        document.getElementById('addVideoForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const videoFile = document.getElementById('videoFile').files[0];
            const videoTitle = document.getElementById('videoTitle').value;
            const videoThumbnail = document.getElementById('videoThumbnail').files[0];

            // Extract video duration using HTML5 video element
            const videoElement = document.createElement('video');
            videoElement.preload = 'metadata';
            videoElement.src = URL.createObjectURL(videoFile);
            
            videoElement.onloadedmetadata = function() {
                window.URL.revokeObjectURL(videoElement.src);
                const duration = videoElement.duration;
                const minutes = Math.floor(duration / 60);
                const seconds = Math.floor(duration % 60);
                const durationText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                
                // Create a new video card
                const newVideoCard = document.createElement('div');
                newVideoCard.className = 'course-card dark-transition bg-white dark:bg-gray-800 rounded-xl p-6';
                newVideoCard.innerHTML = `
                    <img src="${URL.createObjectURL(videoThumbnail)}" alt="Video Thumbnail" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="font-semibold dark-transition text-gray-900 dark:text-white mb-2">${videoTitle}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Duration: ${durationText}</p>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500">Edit Video</button>
                `;

                // Add the new video card to the grid
                document.querySelector('.grid').appendChild(newVideoCard);

                // Hide the modal and reset the form
                document.getElementById('addVideoModal').classList.remove('show');
                document.getElementById('addVideoForm').reset();
            };
        });

        // Handle Post Playlist button click
        document.getElementById('postPlaylistBtn').addEventListener('click', function() {
            // Here you can add code to handle posting the playlist, e.g., send it to the server
            alert('Playlist posted successfully!');
        });
    </script>

    <!-- Footer -->
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
</body>
</html>