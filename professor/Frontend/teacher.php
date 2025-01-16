<?php
// session_start();

// // Check if the session variable 'client' is not set
// if (!isset($_SESSION['client'])) {
//     header('location:../../login/frontend/singin.php');
//     exit(); 
// }

// // Now check if the user is a teacher or is approved
// if ($_SESSION['client']['role'] != 'teacher' && $_SESSION['client']['is_approved'] != 1) {
//     header('location:../../login/frontend/singin.php');
//     exit(); 
// }
require_once '../Backend/get_all_tags.php';
require_once '../Backend/get_all_categorie.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Teacher Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <!-- Profile Header -->
            <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-8">
    <div class="flex flex-col md:flex-row items-center md:items-start">
        <div class="relative mb-4 md:mb-0 md:mr-6">
            <!-- Profile Image -->
            <img id="profileImage" src="/api/placeholder/128/128" alt="Profile" class="rounded-full w-32 h-32">

            <!-- Hidden File Input -->
            <input id="fileInput" type="file" accept="image/*" class="hidden">

            <!-- Camera Icon -->
            <button id="changePhotoIcon" 
                class="absolute bottom-2 right-2 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l-2-2m0 0l2-2m-2 2h8m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2h-6m-6 0H4a2 2 0 00-2 2v10a2 2 0 002 2h6z" />
                </svg>
            </button>
        </div>

        <div class="text-center md:text-left flex-grow">
            <h1 class="text-2xl font-bold mb-2">Jane Smith</h1>
            <p class="text-gray-400 mb-4">Web Development Instructor</p>
            <div class="flex flex-wrap justify-center md:justify-start gap-4">
                <div>
                    <i class="fas fa-book-open mr-2"></i>
                    <span>10 Courses</span>
                </div>
                <div>
                    <i class="fas fa-user-graduate mr-2"></i>
                    <span>200 Students</span>
                </div>
                <div>
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>Age: 30</span>
                </div>
            </div>
        </div>
                    <button id="editProfileBtn" class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Edit Profile</button>
                </div>
            </div>
            <div id="editProfileModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-gray-800 rounded-lg shadow-lg w-96 p-6 text-gray-300">
        <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
        <form id="editProfileForm">
            <!-- Name -->
            <div class="mb-4">
                <label for="profileName" class="block text-gray-400 font-medium">Name</label>
                <input type="text" id="profileName" class="mt-2 block w-full p-3 border border-gray-700 rounded-lg bg-gray-700 text-gray-200" value="Jane Smith">
            </div>
            <!-- Job Title -->
            <div class="mb-4">
                <label for="profileTitle" class="block text-gray-400 font-medium">Job Title</label>
                <input type="text" id="profileTitle" class="mt-2 block w-full p-3 border border-gray-700 rounded-lg bg-gray-700 text-gray-200" value="Web Development Instructor">
            </div>
            <!-- Age -->
            <div class="mb-4">
                <label for="profileAge" class="block text-gray-400 font-medium">Age</label>
                <input type="number" id="profileAge" class="mt-2 block w-full p-3 border border-gray-700 rounded-lg bg-gray-700 text-gray-200" value="30">
            </div>
            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="button" id="saveProfileBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                    Save
                </button>
                <button type="button" id="closeProfileModalBtn" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-800 rounded-xl p-6 animate-slide-in" style="animation-delay: 0.1s">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400">Total Playlists</p>
                            <h3 class="text-2xl font-bold">12</h3>
                        </div>
                        <i class="fas fa-list text-3xl text-blue-500"></i>
                    </div>
                </div>
                <div class="bg-gray-800 rounded-xl p-6 animate-slide-in" style="animation-delay: 0.2s">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400">In Progress</p>
                            <h3 class="text-2xl font-bold">5</h3>
                        </div>
                        <i class="fas fa-clock text-3xl text-yellow-500"></i>
                    </div>
                </div>
                <div class="bg-gray-800 rounded-xl p-6 animate-slide-in" style="animation-delay: 0.3s">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400">Completed</p>
                            <h3 class="text-2xl font-bold">7</h3>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-500"></i>
                    </div>
                </div>
            </div>
                   <!-- Content Tabs -->
        <div class="flex justify-center space-x-4 mb-8">
            <button id="showVideos" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600">Videos</button>
            <button id="showDocuments" class="bg-green-500 text-white px-6 py-3 rounded hover:bg-green-600">Documents</button>
        </div>

        <!-- Videos Section -->
        <div id="videosContent" class="">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <article class="course-card bg-gray-800 rounded-xl overflow-hidden">
                            <div class="relative">
                                <img src="video-thumbnail.jpg" alt="Video thumbnail" class="w-full h-48 object-cover">
                                <span class="absolute bottom-2 right-2 bg-black bg-opacity-75 text-white px-2 py-1 rounded">15:30</span>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2">Introduction to Web Development</h3>
                                <div class="mb-2">
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <span class="bg-blue-600 text-xs px-2 py-1 rounded">Web Dev</span>
                                        <span class="bg-purple-600 text-xs px-2 py-1 rounded">Beginner</span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <h4 class="text-sm font-medium text-gray-400">Learning Objectives:</h4>
                                    <ul class="text-sm text-gray-300 list-disc list-inside">
                                        <li>HTML Basics</li>
                                        <li>CSS Fundamentals</li>
                                    </ul>
                                </div>
                                <a href="video-details.html" class="text-blue-400 text-sm hover:text-blue-300">View Details →</a>
                                <div class="flex justify-between mt-4">
                                    <button onclick="editVideo('videoId')" class="text-yellow-500">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteVideo('videoId')" class="text-red-500">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </article>
                        
                        <!-- More video cards... -->
                    </div>
                    <button id="addNewVideoBtn" class="mt-8 px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-500">
                        Add New Video
                    </button>
                </div>

                <!-- Documents Section -->
                <div id="documentsContent" class="hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <article class="course-card bg-gray-800 rounded-xl overflow-hidden">
            <div class="p-4">
                <div class="flex justify-center mb-4">
                    <i class="fas fa-file-pdf text-4xl text-red-500"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Web Development Guide</h3>
                <div class="mb-2">
                    <div class="flex flex-wrap gap-2 mb-2">
                        <span class="bg-green-600 text-xs px-2 py-1 rounded">Documentation</span>
                        <span class="bg-yellow-600 text-xs px-2 py-1 rounded">Guide</span>
                    </div>
                </div>
                <div class="mb-2">
                    <h4 class="text-sm font-medium text-gray-400">Learning Objectives:</h4>
                    <ul class="text-sm text-gray-300 list-disc list-inside">
                        <li>Understanding Documentation</li>
                        <li>Best Practices</li>
                    </ul>
                </div>
                <a href="document-details.html" class="text-green-400 text-sm hover:text-green-300">View Details →</a>
                <div class="flex justify-between mt-4">
                    <button onclick="editDocument('documentId')" class="text-yellow-500">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteDocument('documentId')" class="text-red-500">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </article>

                <!-- More document cards... -->
            </div>
            <button id="addNewDocBtn" class="mt-8 px-6 py-3 bg-green-600 text-white rounded hover:bg-green-500">
                Add New Document
            </button>
        </div>

     <!-- Add Video Modal -->
            <!-- Add Video Modal -->
            <div id="addVideoModal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Add New Video</h2>
                        <button class="closeModal text-gray-400 hover:text-white">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <form id="addVideoForm" class="space-y-6" action="../Backend/set_vedio_to_db.php" method="POST" enctype="multipart/form-data">
                        <!-- Basic Information -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Video Title</label>
                            <input name="title" type="text" class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required>
                        </div>

                        <!-- Video Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Video File</label>
                            <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center">
                                <input name="video" type="file" id="videoUpload" accept="video/*" class="hidden">
                                <label for="videoUpload" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-400">Click to upload</p>
                                    <p class="text-sm text-gray-500">MP4, MP3 or Ogg (MAX. 800MB)</p>
                                </label>
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Thumbnail</label>
                            <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center">
                                <input name="thumbnail" type="file" id="thumbnailUpload" accept="image/*" class="hidden">
                                <label for="thumbnailUpload" class="cursor-pointer">
                                    <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-400">Click to upload thumbnail</p>
                                    <p class="text-sm text-gray-500">JPG, PNG or GIF (MAX. 2MB)</p>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Video Duration</label>
                            <div class="flex space-x-2">
                                <input name="duration_hours" type="number" min="0" max="3" placeholder="Hours" class="w-1/3 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required>
                                <input name="duration_minutes" type="number" min="0" max="59" placeholder="Minutes" class="w-1/3 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required>
                                <input name="duration_seconds" type="number" min="0" max="59" placeholder="Seconds" class="w-1/3 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required>
                            </div>
                        </div>
                        <!-- Categories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Categories</label>
                            <div class="flex flex-wrap gap-2 mb-2" id="videoCategories"></div>
                            <div class="flex gap-2">
                            <div id="selectcategorie"></div>
                            <select id="videoCategorySelect" class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2">
                                <option value="" disabled selected>Select category</option>
                                    <?php foreach($result as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['id']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" onclick="addCategory('video')" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                                    Add
                                </button>
                            </div>
                        </div>

                        <!-- Tags -->
               <!-- Tags -->
<div>
    <label class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
    <div class="flex flex-wrap gap-2 mb-2" id="videoTags"></div>
    <div class="flex gap-2">
        <div id="selecttags"></div>
        <select id="videoTAGSelect" class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2">
            <option value="" disabled selected>Select tag</option>
            <?php foreach($result2 as $tag): ?>
                <option value="<?php echo htmlspecialchars($tag['id']); ?>"><?php echo htmlspecialchars($tag['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="button" onclick="addTag('video')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
            Add
        </button>
    </div>
</div>

                        <!-- Learning Objectives -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Learning Objectives</label>
                            <div class="space-y-2 mb-2" id="videoLearningObjectives"></div>
                            <div class="flex gap-2">
                                <input type="text" id="videoObjectiveInput" 
                                       class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                                       placeholder="Add learning objective">
                                <button type="button" onclick="addLearningObjective('video')" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                                    Add
                                </button>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                            <textarea name="description" rows="4" class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end gap-3">
                            <button type="button" class="closeModal px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                                Upload Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>


<!-- Add Document Modal -->
<div id="addDocModal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Add New Document</h2>
            <button class="closeModal text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="addDocForm" class="space-y-6" action="../Backend/set_document_to_db.php" method="POST" enctype="multipart/form-data"  >
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Document Title</label>
                <input name="document_title" type="text" class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Document File</label>
                <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center">
                    <input name="document" type="file" id="docUpload" accept=".pdf,.doc,.docx" class="hidden">
                    <label for="docUpload" class="cursor-pointer">
                        <i class="fas fa-file-upload text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-400">Click to upload or drag and drop</p>
                        <p class="text-sm text-gray-500">PDF, DOC, or DOCX (MAX. 50MB)</p>
                    </label>
                </div>
            </div>

            <!-- Categories -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Categories</label>
                <div class="flex flex-wrap gap-2 mb-2" id="docCategories"></div>
                <div class="flex gap-2">
                    <input name="categorie" type="text" id="docCategoryInput" 
                           class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                           placeholder="Add category">
                    <button type="button" onclick="addCategory('doc')" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                        Add
                    </button>
                </div>
            </div>

            <!-- Tags -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
                <div class="flex flex-wrap gap-2 mb-2" id="docTags"></div>
                <div class="flex gap-2">
                    <input type="text" id="docTagInput" 
                           class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                           placeholder="Add tag">
                    <button type="button" onclick="addTag('doc')" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                        Add
                    </button>
                </div>
            </div>

            <!-- Learning Objectives -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Learning Objectives</label>
                <div class="space-y-2 mb-2" id="docLearningObjectives"></div>
                <div class="flex gap-2">
                    <input type="text" id="docObjectiveInput" 
                           class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                           placeholder="Add learning objective">
                    <button type="button" onclick="addLearningObjective('doc')" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                        Add
                    </button>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="document_description" rows="4" class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required></textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <button type="button" class="closeModal px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                    Upload Document
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Video Modal -->
<div id="editVideoModal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Edit Video</h2>
            <button class="closeModal text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="editVideoForm" class="space-y-6">
            <!-- Basic Information -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Video Title</label>
                <input type="text" id="editVideoTitleInput" class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required>
            </div>

            <!-- Video Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Video File</label>
                <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center">
                    <input type="file" id="editVideoUpload" accept="video/*" class="hidden">
                    <label for="editVideoUpload" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-400">Click to upload or drag and drop</p>
                        <p class="text-sm text-gray-500">MP4, WebM or Ogg (MAX. 800MB)</p>
                    </label>
                </div>
            </div>

            <!-- Thumbnail -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Thumbnail</label>
                <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center">
                    <input type="file" id="editThumbnailUpload" accept="image/*" class="hidden">
                    <label for="editThumbnailUpload" class="cursor-pointer">
                        <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-400">Click to upload thumbnail</p>
                        <p class="text-sm text-gray-500">JPG, PNG or GIF (MAX. 2MB)</p>
                    </label>
                </div>
            </div>

            <!-- Categories -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Categories</label>
                <div class="flex flex-wrap gap-2 mb-2" id="editVideoCategories"></div>
                <div class="flex gap-2">
                    <input type="text" id="editVideoCategoryInput" 
                           class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                           placeholder="Add category">
                    <button type="button" onclick="addCategory('editVideo')" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                        Add
                    </button>
                </div>
            </div>

            <!-- Tags -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
                <div class="flex flex-wrap gap-2 mb-2" id="editVideoTags"></div>
                <div class="flex gap-2">
                    <input type="text" id="editVideoTagInput" 
                           class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                           placeholder="Add tag">
                    <button type="button" onclick="addTag('editVideo')" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                        Add
                    </button>
                </div>
            </div>

            <!-- Learning Objectives -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Learning Objectives</label>
                <div class="space-y-2 mb-2" id="editVideoLearningObjectives"></div>
                <div class="flex gap-2">
                    <input type="text" id="editVideoObjectiveInput" 
                           class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                           placeholder="Add learning objective">
                    <button type="button" onclick="addLearningObjective('editVideo')" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                        Add
                    </button>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea rows="4" class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required></textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <button type="button" class="closeModal px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Document Modal -->
<div id="editDocModal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Edit Document</h2>
            <button class="closeModal text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="editDocForm" class="space-y-6">
            <!-- Basic Information -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Document Title</label>
                <input type="text" id="editDocTitleInput" class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required>
            </div>

            <!-- Document Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Document File</label>
                <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center">
                    <input type="file" id="editDocUpload" accept=".pdf,.doc,.docx" class="hidden">
                    <label for="editDocUpload" class="cursor-pointer">
                        <i class="fas fa-file-upload text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-400">Click to upload or drag and drop</p>
                        <p class="text-sm text-gray-500">PDF, DOC, or DOCX (MAX. 50MB)</p>
                    </label>
                </div>
            </div>

            <!-- Categories -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Categories</label>
                <div class="flex flex-wrap gap-2 mb-2" id="editDocCategories"></div>
                <div class="flex gap-2">
                    <select name="" id="editDocCategoryInput"class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                    >
                    <?php foreach($result as $category):    ?>
                     <option value="$category['id']"><?php $category['name']?></option> .'<br>';
                           <?php endforeach;?>
                    </select>
                </select>
                           placeholder="Add category">
                    <button type="button" onclick="addCategory('editDoc')" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                        Add
                    </button>
                </div>
            </div>

            <!-- Tags -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
                <div class="flex flex-wrap gap-2 mb-2" id="editDocTags"></div>
                <div class="flex gap-2">
                    <input type="text" id="editDocTagInput" 
                           class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                           placeholder="Add tag">
                    <button type="button" onclick="addTag('editDoc')" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                        Add
                    </button>
                </div>
            </div>

            <!-- Learning Objectives -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Learning Objectives</label>
                <div class="space-y-2 mb-2" id="editDocLearningObjectives"></div>
                <div class="flex gap-2">
                    <input type="text" id="editDocObjectiveInput" 
                           class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                           placeholder="Add learning objective">
                    <button type="button" onclick="addLearningObjective('editDoc')" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                        Add
                    </button>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea rows="4" class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required></textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <button type="button" class="closeModal px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
<script>document.addEventListener('DOMContentLoaded', function() {
    const showVideosBtn = document.getElementById('showVideos');
    const showDocsBtn = document.getElementById('showDocuments');
    const videosContent = document.getElementById('videosContent');
    const documentsContent = document.getElementById('documentsContent');
    const addVideoBtn = document.getElementById('addNewVideoBtn');
    const addDocBtn = document.getElementById('addNewDocBtn');
    const videoModal = document.getElementById('addVideoModal');
    const docModal = document.getElementById('addDocModal');
    const closeButtons = document.querySelectorAll('.closeModal');

    // Toggle content sections
    showVideosBtn.addEventListener('click', () => {
        videosContent.classList.remove('hidden');
        documentsContent.classList.add('hidden');
    });

    showDocsBtn.addEventListener('click', () => {
        documentsContent.classList.remove('hidden');
        videosContent.classList.add('hidden');
    });

    // Show modals
    addVideoBtn.addEventListener('click', () => {
        videoModal.classList.add('show');
    });

    addDocBtn.addEventListener('click', () => {
        docModal.classList.add('show');
    });

    // Close modals
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            videoModal.classList.remove('show');
            docModal.classList.remove('show');
        });
    });
});

// Category Management
function addCategory(type) {
    const select = document.getElementById(`${type}CategorySelect`);
    const container = document.getElementById(`${type}Categories`);
    const value = select.value;
    const text = select.options[select.selectedIndex].text;
    
    if (value) {
        const span = document.createElement('span');
        span.className = 'bg-blue-500 text-white px-2 py-1 rounded-full text-sm flex items-center';
        span.innerHTML = `
            ${text}
            <button onclick="this.parentElement.remove()" class="ml-2 text-xs">&times;</button>
            <input type="hidden" name="categories[]" value="${value}">
        `;

        container.appendChild(span);
        select.value = ''; 
    }
}

// Tag Management
function addTag(type) {
    const select = document.getElementById(`${type}TAGSelect`);
    const container = document.getElementById(`${type}Tags`);
    const value = select.value;
    const text = select.options[select.selectedIndex].text;
    
    if (value) {
        const span = document.createElement('span');
        span.className = 'bg-green-500 text-white px-2 py-1 rounded-full text-sm flex items-center';
        span.innerHTML = `
            ${text}
            <button onclick="this.parentElement.remove()" class="ml-2 text-xs">&times;</button>
            <input type="hidden" name="tags[]" value="${value}">
        `;
        container.appendChild(span);
        select.value = ''; 
        if (value) {
        // Create a hidden input to store the last tag value
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'categorieselect[]';
        hiddenInput.value = value;
        document.getElementById('selectcategorie').appendChild(hiddenInput);
    }
    }
}

// Learning Objectives Management
function addLearningObjective(type) {
    const input = document.getElementById(`${type}ObjectiveInput`);
    const container = document.getElementById(`${type}LearningObjectives`);
    const value = input.value.trim();
    
    if (value) {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2';
        div.innerHTML = `
            <span class="flex-1 bg-gray-700 p-2 rounded">${value}</span>
            <button onclick="this.parentElement.remove()" class="text-red-500">&times;</button>
            <input type="hidden" name="learning[]" value="${value}">
        `;
        container.appendChild(div);
        input.value = '';
        if (value) {
        // Create a hidden input to store the last tag value
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'tagsselect[]';
        hiddenInput.value = value;
        document.getElementById('selecttags').appendChild(hiddenInput);
    }
    }
}</script>
</body>
</html>
                            