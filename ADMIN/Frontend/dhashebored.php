<?php
session_start();
if(!isset($_SESSION['client']))
{
    if($_SESSION['client']['role']!='admin'){
         header('location:../../login/frontend/singin.php');
    exit(); 
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dark-transition {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .hidden {
            display: none;
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark-transition">
    <!-- Sidebar -->
    <div class="flex min-h-screen">
        <div class="bg-white dark:bg-gray-800 dark-transition w-64 min-h-screen">
            <div class="flex items-center justify-center mt-10">
                <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">Youdemy Admin</span>
            </div>
            <nav class="mt-10">
                <a href="#" class="flex items-center px-6 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark-transition" onclick="showSection('dashboard')">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="#" class="flex items-center px-6 py-2 mt-4 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark-transition" onclick="showSection('users')">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                <a href="#" class="flex items-center px-6 py-2 mt-4 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark-transition" onclick="showSection('courses')">
                    <i class="fas fa-book mr-3"></i>
                    Courses
                </a>
                <a href="#" class="flex items-center px-6 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark-transition" onclick="showSection('categories')">
                    <i class="fas fa-list-alt mr-3"></i>
                    Categories
                </a>
                <a href="#" class="flex items-center px-6 py-2 mt-4 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark-transition" onclick="showSection('tags')">
                    <i class="fas fa-tags mr-3"></i>
                    Tags
                </a>
                <a href="#" class="flex items-center px-6 py-2 mt-4 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark-transition" onclick="showSection('statistics')">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Statistics
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 bg-gray-100 dark:bg-gray-900 dark-transition">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 dark-transition">
                <div class="flex items-center space-x-4">
                    <button onclick="toggleDarkMode()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-moon dark:hidden text-gray-600"></i>
                        <i class="fas fa-sun hidden dark:block text-yellow-400"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="relative text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                    </button>
                    <div class="relative" id="profileDropdown">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <img src="/api/placeholder/32/32" alt="Profile" class="h-8 w-8 rounded-full ring-2 ring-blue-500">
                            <span class="hidden md:block text-gray-700 dark:text-gray-200">Admin</span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>
                        <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg dark-transition bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 animate-fade-in">
                            <div class="py-1">
                                <a href="/profile" class="dark-transition block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                <a href="/settings" class="dark-transition block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
                                <a href="/logout" class="dark-transition block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 py-8">
                <!-- Dashboard Section -->
                <div id="dashboard" class="section">
                    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">Dashboard</h2>
                    <!-- Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 dark-transition p-6 rounded-lg shadow-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Courses</h3>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">120</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 dark-transition p-6 rounded-lg shadow-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Users</h3>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">540</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 dark-transition p-6 rounded-lg shadow-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Top Instructor</h3>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">John Doe</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 dark-transition p-6 rounded-lg shadow-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-red-100 text-red-600">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Top Course</h3>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Python Bootcamp</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Section -->
                <div id="users" class="section hidden">
                    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">User Management</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 dark-transition rounded-lg">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Name</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Email</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Role</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Status</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4">Jane Smith</td>
                                    <td class="py-2 px-4">jane.smith@example.com</td>
                                    <td class="py-2 px-4">Student</td>
                                    <td class="py-2 px-4">
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Active</span>
                                    </td>
                                    <td class="py-2 px-4">
                                        <button class="text-red-600 hover:text-red-900">Suspend</button>
                                        <button class="text-blue-600 hover:text-blue-900 ml-4">Edit</button>
                                    </td>
                                </tr>
                                <!-- More user rows... -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Courses Section -->
                <div id="courses" class="section hidden">
                    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">Course Management</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 dark-transition rounded-lg">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Title</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Category</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Instructor</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Enrollments</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4">Complete Python Bootcamp</td>
                                    <td class="py-2 px-4">Programming</td>
                                    <td class="py-2 px-4">Sarah Johnson</td>
                                    <td class="py-2 px-4">1,200</td>
                                    <td class="py-2 px-4">
                                        <button class="text-red-600 hover:text-red-900">Delete</button>
                                        <button class="text-blue-600 hover:text-blue-900 ml-4">Edit</button>
                                    </td>
                                </tr>
                                <!-- More course rows... -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Categories Section -->
                <div id="categories" class="section hidden">
                    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">Manage Categories</h2>
                    <form action="../backend/insert_category_to_db.php" method="POST">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Categories</label>
                <div class="flex flex-wrap gap-2 mb-2" id="videoCategories"></div>
                <div class="flex gap-2">
                    <input name="last_cat" type="text" id="videoCategoryInput" 
                           class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" 
                           placeholder="Add category">
                    <button type="button" onclick="addCategory('video')" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                        Add
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Create</button>
    </form>
                </div>

                    <div class="bg-white dark:bg-gray-800 dark-transition p-6 rounded-lg shadow-lg mt-10">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Existing Categories</h3>
                        <table class="min-w-full bg-white dark:bg-gray-800 dark-transition rounded-lg">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Category Name</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example row -->
                                <tr>
                                    <td class="py-2 px-4">Programming</td>
                                    <td class="py-2 px-4">
                                        <button class="text-red-600 hover:text-red-900">Delete</button>
                                        <button class="text-blue-600 hover:text-blue-900 ml-4">Edit</button>
                                    </td>
                                </tr>
                                <!-- More rows... -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tags Section -->
                <div id="tags" class="section hidden">
                <div class="mb-10">
    <form action="../backend/insert_tags_to_db.php" method="POST">
        <label class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
        <div class="flex flex-wrap gap-2 mb-2" id="videoTags"></div>
        <div class="flex gap-2">
            <input name="last_tag" type="text" id="videoTagInput" class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" placeholder="Add tag">
            <button type="button" onclick="addTag('video')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Add</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Create</button>
        </div>
    </form>
</div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 dark-transition rounded-lg">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Tag</th>
                                    <th class="py-2 px-4 bg-gray-100 dark:bg-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4">Python</td>
                                    <td class="py-2 px-4">
                                        <button class="text-red-600 hover:text-red-900">Delete</button>
                                        <button class="text-blue-600 hover:text-blue-900 ml-4">Edit</button>
                                    </td>
                                </tr>
                                <!-- More tag rows... -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Statistics Section -->
                <div id="statistics" class="section hidden">
                    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white dark:bg-gray-800 dark-transition p-6 rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Courses</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">120</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 dark-transition p-6 rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Users</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">540</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 dark-transition p-6 rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Top Instructor</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">John Doe</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 dark-transition p-6 rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Top Course</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">Python Bootcamp</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(sectionId).classList.remove('hidden');
            localStorage.setItem('activeSection', sectionId);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const activeSection = localStorage.getItem('activeSection') || 'dashboard';
            showSection(activeSection);
        });

        const profileDropdown = document.getElementById('profileDropdown');
        profileDropdown.addEventListener('click', () => {
            const menu = document.createElement('div');
            menu.className = 'absolute right-0 mt-2 w-48 rounded-lg shadow-lg dark-transition bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 animate-fade-in';
            menu.innerHTML = `
                <div class="py-1">
                    <a href="/profile" class="dark-transition block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                    <a href="/settings" class="dark-transition block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
                    <a href="/logout" class="dark-transition block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
                </div>
            `;
            profileDropdown.appendChild(menu);
        });
        function addTag(type) {
    const input = document.getElementById(`${type}TagInput`);
    const container = document.getElementById(`${type}Tags`);
    const value = input.value.trim();
    
    if (value) {
        // Create a span element to display the tag
        const tag = document.createElement('span');
        tag.className = 'bg-green-500 text-white px-2 py-1 rounded-full text-sm flex items-center';
        tag.innerHTML = `
            ${value}
            <button onclick="removeTag(this)" class="ml-2 text-xs">&times;</button>
        `;
        container.appendChild(tag);
        
        // Create a hidden input to store the tag value
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'tags[]';
        hiddenInput.value = value;
        container.appendChild(hiddenInput);

        // Clear the input field
        input.value = '';
    }
}

function removeTag(button) {
    const tagSpan = button.parentElement;
    const hiddenInput = tagSpan.nextElementSibling;
    
    // Remove the tag span and the corresponding hidden input
    tagSpan.remove();
    hiddenInput.remove();
}

// Ensure the last tag in the input field is added before form submission
document.querySelector('form').addEventListener('submit', function(event) {
    const input = document.getElementById('videoTagInput');
    const value = input.value.trim();

    if (value) {
        // Create a hidden input to store the last tag value
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'tags[]';
        hiddenInput.value = value;
        document.getElementById('videoTags').appendChild(hiddenInput);
    }
});
// Category Management
function addCategory(type) {
    const input = document.getElementById(`${type}CategoryInput`);
    const container = document.getElementById(`${type}Categories`);
    const value = input.value.trim();
    
    if (value) {
        const tag = document.createElement('span');
        tag.className = 'bg-blue-500 text-white px-2 py-1 rounded-full text-sm flex items-center';
        tag.innerHTML = `
            ${value}
            <button onclick="this.parentElement.remove()" class="ml-2 text-xs">&times;</button>
        `;
        container.appendChild(tag);
        input.value = '';
        if (value) {
        // Create a hidden input to store the last tag value
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'categorie[]';
        hiddenInput.value = value;
        document.getElementById('videoCategories').appendChild(hiddenInput);
    }
};
    

}

</script>
