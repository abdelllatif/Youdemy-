<?php
session_start();
require_once '../../Classes/class_course_content.php';
require_once '../../Classes/class_user.php';

$userId = $_SESSION['client']['id']; // Assuming the user ID is 1, replace with actual logged-in user ID

// Initialize the handler classes
$videoHandler = new VideoHandler();
$documentHandler = new DocumentContent(0,0,0);

// Fetch videos and documents
$videos = $videoHandler->afficherByUserId($userId);
$documents = $documentHandler->afficherByUserId($userId);
$userId = $_SESSION['client']['id'];

$user = new User('','','','',''); // Instantiate the User class (pass empty values, as we only need the methods)

$userProfile = $user->getProfile($userId);
$isStudent =$_SESSION['client']['role']  ;// Check
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Additional custom styles */
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
  <nav class="fixed w-full z-50 bg-white dark:bg-gray-800 shadow-lg">
    <!-- Your navigation code here -->
  </nav>

  <main class="pt-20">
    <div class="max-w-7xl mx-auto px-4 py-8">
<!-- Profile Header -->
<!-- Profile Header -->
<div class="bg-gray-800 rounded-lg shadow-md p-6 mb-8">
    <div class="flex flex-col md:flex-row items-center md:items-start">
        <div class="mb-4 md:mb-0 md:mr-6 text-center">
            <img src="<?= $userProfile['avatar_path'] ?>" alt="Profile" class="rounded-full w-32 h-32">
            <!-- Change Photo Form below the photo -->
            <form action="change_photo.php" method="POST" enctype="multipart/form-data" class="mt-4">
                <label for="profile_photo" class="cursor-pointer text-blue-400 text-sm hover:text-blue-300">Change Photo</label>
                <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*">
                <button type="submit" class="hidden">Submit</button>
            </form>
        </div>
        
        <div class="text-center md:text-left flex-grow">
            <h1 class="text-2xl font-bold mb-2"><?= $userProfile['first_name'] . ' ' . $userProfile['last_name'] ?></h1>
            <p class="text-gray-400 mb-4"><?= $isStudent ? 'Student' : 'Teacher' ?> - <?= $userProfile['role'] ?></p>
            <div class="flex flex-wrap justify-center md:justify-start gap-4">
                <div><i class="fas fa-book-reader mr-2"></i><span>5 Courses</span></div>
                <div><i class="fas fa-certificate mr-2"></i><span>3 Certificates</span></div>
                <div><i class="fas fa-calendar-alt mr-2"></i><span>Age: <?= 25 ?></span></div>
            </div>
        </div>
    </div>
</div>


        <!-- My Courses Section -->
        <div class="mb-8">
            <div class="flex space-x-4">
                <button id="afficherVideoBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Affiche Video</button>
                <button id="afficherDocBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Affiche Document</button>
            </div>
        </div>

        <!-- Video and Document Content -->
        <div id="contentSection" class="space-y-6">
            <div id="videoContent" class="">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                        <!-- Categories and Tags -->
                        <div class="flex flex-wrap gap-2 mb-2">
                            <?php if (is_array($video['categories'])): ?>
                                <?php foreach ($video['categories'] as $category): ?>
                                    <span class="bg-blue-600 text-xs px-2 py-1 rounded"><?= htmlspecialchars($category); ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="bg-blue-600 text-xs px-2 py-1 rounded"><?= htmlspecialchars($video['categories'] ?? 'Category'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-2">
                            <?php if (is_array($video['tags'])): ?>
                                <?php foreach ($video['tags'] as $tag): ?>
                                    <span class="bg-green-600 text-xs px-2 py-1 rounded"><?= htmlspecialchars($tag); ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="bg-green-600 text-xs px-2 py-1 rounded"><?= htmlspecialchars($video['tags'] ?? 'Tag'); ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Teacher Information -->
                        <div class="flex items-center mb-2">
                            <img src="../../Uploads/<?= htmlspecialchars($video['avatar_path']); ?>" alt="Teacher Avatar" class="w-8 h-8 rounded-full mr-2">
                            <span class="text-sm text-gray-400"><?= htmlspecialchars($video['first_name'] . ' ' . $video['last_name']); ?> - <?= htmlspecialchars(ucfirst($video['role'])); ?></span>
                        </div>
                        <!-- Ratings and Other Information -->
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
                                <?php foreach ($video['learning'] as $objective): ?>
                                    <li><?= htmlspecialchars($objective); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <!-- Join Course Button -->
                        <?php if (!isset($_SESSION['client']) || $_SESSION['client']['role'] !== 'student'): ?>
                            <span class="text-red-500 font-semibold text-sm bg-yellow-200 p-2 rounded-md">Veuillez vous connecter pour participer</span>
                        <?php else: ?>
                            <form action="../Backend/vedio_specific.php" method="POST">
                                <input name="idved" type="hidden" value="<?= htmlspecialchars($video['id']); ?>">
                                <input name="rejoindre" type="hidden" value=1>
                                <button type="submit" class="text-blue-400 text-sm hover:text-blue-300">Rejoindre ce cours →</button>
                            </form>
                        <?php endif ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
            </div>








            <div id="docContent" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($documents as $document): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:scale-105 transition duration-300">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <?php
                                    $filePath = $document['document_path'] ?? '';
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
                                            <?= htmlspecialchars($document['title']); ?>
                                        </h2>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            <?= htmlspecialchars($document['first_name'] . ' ' . $document['last_name']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                <?= htmlspecialchars($document['description']); ?>
                            </p>
                            <?php if (!empty($document['learning'])): ?>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <h4 class="font-semibold">Learning Objectives:</h4>
                                    <ul class="list-disc pl-5">
                                        <?php foreach ($document['learning'] as $learning): ?>
                                            <li><?= htmlspecialchars($learning); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($document['categories'])): ?>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <h4 class="font-semibold">Categories:</h4>
                                    <ul class="flex flex-wrap gap-2">
                                        <?php foreach ($document['categories'] as $category): ?>
                                            <li class="bg-blue-600 text-xs px-2 py-1 rounded"><?= htmlspecialchars($category); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($document['tags'])): ?>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <h4 class="font-semibold">Tags:</h4>
                                    <ul class="flex flex-wrap gap-2">
                                        <?php foreach ($document['tags'] as $tag): ?>
                                            <li class="bg-green-600 text-xs px-2 py-1 rounded"><?= htmlspecialchars($tag); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <img class="rounded-full w-10 h-10" src="../../Uploads/<?= htmlspecialchars($document['avatar_path']); ?>" alt="">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-user-shield"></i>
                                    <?= htmlspecialchars(ucfirst($document['role'])); ?>
                                </span>
                            </div>
                            <?php if (!isset($_SESSION['client']) || $_SESSION['client']['role'] !== 'student'): ?>
                                <span class="text-red-500 font-semibold text-sm bg-yellow-200 p-2 rounded-md">Connecter pour participer</span>
                            <?php else: ?>
                                <form action="../Backend/document.php" method="POST">
                                    <input name="iddoc" type="hidden" value="<?= htmlspecialchars($document['id']); ?>">
                                    <input name="rejoindre" type="hidden" value=1>
                                    <button type="submit" class="text-blue-400 text-sm hover:text-blue-300">Rejoindre ce cours →</button>
                                </form>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            </div>
        </div>

    </div>
  </main>

  <footer class="bg-gray-800 border-t border-gray-700 mt-8">
    <!-- Your footer code here -->
  </footer>

  <script>
      document.getElementById('afficherVideoBtn').addEventListener('click', () => {
          document.getElementById('videoContent').classList.remove('hidden');
          document.getElementById('docContent').classList.add('hidden');
      });

      document.getElementById('afficherDocBtn').addEventListener('click', () => {
          document.getElementById('docContent').classList.remove('hidden');
          document.getElementById('videoContent').classList.add('hidden');
      });
  </script>
</body>
</html>
