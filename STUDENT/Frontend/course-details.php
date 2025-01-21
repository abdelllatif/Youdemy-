<?php
session_start();
if (!isset($_SESSION['client'])) {
    header('location:../../login/frontend/singin.php');
    exit(); 
}
$role = $_SESSION['client']['role'];
$status = $_SESSION['client']['status'];

if ($role != 'student' && $status != 'active') {
    if ($status == 'suspended') {
        header('location:../../login/frontend/suspend.php');
    } else {
        header('location:../../index.php');
    }
    exit();
}

if (isset($_GET['iddoc'])) {
    $document_id = intval($_GET['iddoc']);
    $documentContent = new DocumentContent('', '', 0);
    $document = $documentContent->getDocumentById($document_id);

    if ($document) {
        $file_extension = strtolower(pathinfo($document['document_path'], PATHINFO_EXTENSION));
    } else {
        echo "<p class='text-red-500 font-semibold text-sm'>المستند غير موجود.</p>";
        exit;
    }
} else {
    header("Location: courses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        .download-progress {
            width: 0%;
            transition: width 0.3s ease;
        }
        .description {
            white-space: pre-line; 
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <nav class="bg-gray-800 shadow-lg mb-8">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">Document Platform</h1>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-gray-800 rounded-xl shadow-xl p-6 mb-8 animate-fade-in">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/4 mb-6 md:mb-0">
                    <div class="bg-gray-700 p-8 rounded-xl flex flex-col items-center">
                        <?php if ($file_extension === 'pdf'): ?>
                            <i class="fas fa-file-pdf text-red-500 text-6xl mb-4"></i>
                        <?php elseif (in_array($file_extension, ['xls', 'xlsx'])): ?>
                            <i class="fas fa-file-excel text-green-500 text-6xl mb-4"></i>
                        <?php else: ?>
                            <i class="fas fa-file text-blue-500 text-6xl mb-4"></i>
                        <?php endif; ?>
                        
                        <?php if (!isset($_SESSION['client']) || $_SESSION['client']['role'] !== 'student'): ?>
                            <span class="text-red-500 font-semibold text-sm bg-yellow-200 p-2 rounded-md">Veuillez vous connecter pour participer</span>
                        <?php else: ?>
                            <a href="../../professor/Backend/<?= htmlspecialchars($document['document_path']); ?>" target="_blank" 
                               class="mt-4 w-full bg-green-600 hover:bg-green-500 text-white py-2 px-4 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fas fa-eye mr-2"></i>
                                <span>View</span>
                            </a>
                            <button onclick="downloadDocument()" 
                                    id="downloadBtn"
                                    class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fas fa-download mr-2"></i>
                                <span>Download</span>
                            </button>
                        <?php endif; ?>
                        <!-- Download Progress Bar -->
                        <div id="downloadProgress" class="w-full mt-4 hidden">
                            <div class="w-full bg-gray-600 rounded-full h-2">
                                <div id="progressBar" class="download-progress bg-blue-500 h-2 rounded-full"></div>
                            </div>
                            <div class="text-center mt-2 text-sm text-gray-400">
                                <span id="progressText">0%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-3/4 md:pl-8">
                    <h1 class="text-3xl font-bold mb-4"><?= htmlspecialchars($document['title']); ?></h1>
                    
                    <div class="flex flex-wrap gap-4 mb-6">
                        <div class="flex items-center text-gray-400">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>Updated: <?= date('M d, Y', strtotime($document['updated_at'])); ?></span>
                        </div>
                        <div class="flex items-center text-gray-400">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>Created: <?= date('M d, Y', strtotime($document['created_at'])); ?></span>
                        </div>
                        <div class="flex items-center text-gray-400">
                            <img src="../../professor/Backend//<?= htmlspecialchars($document['avatar_path']); ?>" alt="Teacher Avatar" class="w-10 h-10 rounded-full mr-2">
                            <span>Teacher: <?= htmlspecialchars($document['first_name'] . ' ' . $document['last_name']); ?></span>
                        </div>
                    </div>

                    <!-- عرض الفئات إذا كانت موجودة -->
                    <?php if (!empty($document['categories'])): ?>
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold mb-3">Categories</h2>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($document['categories'] as $category): ?>
                                    <span class="bg-blue-600 px-3 py-1 rounded-full text-sm"><?= htmlspecialchars($category); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- عرض العلامات إذا كانت موجودة -->
                    <?php if (!empty($document['tags'])): ?>
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold mb-3">Tags</h2>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($document['tags'] as $tag): ?>
                                    <span class="bg-blue-600 px-3 py-1 rounded-full text-sm"><?= htmlspecialchars($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-3">Description</h2>
                        <p class="text-gray-300 leading-relaxed description">
                            <?= nl2br(htmlspecialchars($document['description'])); ?>
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold mb-3">Learning Objectives</h2>
                        <ul class="space-y-2">
                            <?php foreach ($document['learning'] as $objective): ?>
                                <li class="flex items-center text-gray-300">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <?= htmlspecialchars($objective); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadDocument() {
            const downloadBtn = document.getElementById('downloadBtn');
            const downloadProgress = document.getElementById('downloadProgress');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            downloadBtn.disabled = true;
            downloadBtn.classList.add('opacity-50');
            downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Downloading...';

            downloadProgress.classList.remove('hidden');

            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 30;
                if (progress > 100) progress = 100;

                progressBar.style.width = `${progress}%`;
                progressText.textContent = `${Math.round(progress)}%`;

                if (progress === 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        const link = document.createElement('a');
                        link.href = '../../professor/Backend/<?= htmlspecialchars($document['document_path']); ?>'; 
                        link.download = '<?= htmlspecialchars($document['title']); ?>.<?= htmlspecialchars($file_extension); ?>';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        downloadBtn.disabled = false;
                        downloadBtn.classList.remove('opacity-50');
                        downloadBtn.innerHTML = '<i class="fas fa-download mr-2"></i>Download';
                        downloadProgress.classList.add('hidden');
                    }, 500);
                }
            }, 500);
        }
    </script>
</body>
</html>