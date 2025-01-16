<?php
require_once 'test.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Playlist - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 mt-28">Document Library</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($result as $resul): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Document Header -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <?php
                                $filePath = $resul['document_path'] ?? '';
                                $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                ?>
                                <?php if ($fileExtension === 'pdf'): ?>
                                    <i class="fas fa-file-pdf text-3xl text-red-500"></i>
                                <?php elseif (in_array($fileExtension, ['xls', 'xlsx'])): ?>
                                    <i class="fas fa-file-excel text-3xl text-green-500"></i>
                                <?php else: ?>
                                    <i class="fas fa-file text-3xl text-blue-500"></i>
                                <?php endif; ?>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 truncate">
                                        <?= htmlspecialchars($resul['title']); ?>
                                    </h2>
                                    <p class="text-sm text-gray-500">
                                        <?= htmlspecialchars($resul['first_name'] . ' ' . $resul['last_name']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Document Description -->
                        <p class="text-gray-600 mb-4 line-clamp-2">
                            <?= htmlspecialchars($resul['description']); ?>
                        </p>

                        <!-- Document Details -->
                        <div class="space-y-2 text-sm text-gray-500">
                            <p class="flex items-center">
                                <i class="fas fa-calendar-alt w-5"></i>
                                <span>Created: <?= date('M d, Y', strtotime($resul['created_at'])); ?></span>
                            </p>
                            <?php if (!empty($resul['updated_at'])): ?>
                            <p class="flex items-center">
                                <i class="fas fa-clock w-5"></i>
                                <span>Updated: <?= date('M d, Y', strtotime($resul['updated_at'])); ?></span>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Document Footer -->
                    <div class="bg-gray-50 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <img class="rounded-lg w-8 h-8" src="<?= htmlspecialchars($resul['avatar_path']); ?>" alt="">
                            <span class="text-sm font-medium text-gray-500">
                                <i class="fas fa-user-shield"></i>
                                <?= htmlspecialchars(ucfirst($resul['role'])); ?>
                            </span>
                            
                            <!-- View Button (if document is viewable in browser) -->
                            <a href="<?= htmlspecialchars($resul['document_path']); ?>" target="_blank" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-eye mr-2"></i>
                                View
                            </a>

                            <!-- Download Button -->
                            <a href="<?= htmlspecialchars($resul['document_path']); ?>" download
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-download mr-2"></i>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Your existing JavaScript
    </script>
</body>
</html>