<!-- / -->
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
                        <i class="fas fa-file-pdf text-red-500 text-6xl mb-4"></i>
                        <button onclick="downloadDocument()" 
                                id="downloadBtn"
                                class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            <span>Download</span>
                        </button>
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
                    <h1 class="text-3xl font-bold mb-4">Web Development Guide 2024</h1>
                    
                    <div class="flex flex-wrap gap-4 mb-6">
                        <div class="flex items-center text-gray-400">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>Updated: Jan 14, 2024</span>
                        </div>
                        <div class="flex items-center text-gray-400">
                            <i class="fas fa-file-alt mr-2"></i>
                            <span>25 pages</span>
                        </div>
                        <div class="flex items-center text-gray-400">
                            <i class="fas fa-file-archive mr-2"></i>
                            <span>15.2 MB</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-3">Tags</h2>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-600 px-3 py-1 rounded-full text-sm">Web Development</span>
                            <span class="bg-green-600 px-3 py-1 rounded-full text-sm">HTML</span>
                            <span class="bg-purple-600 px-3 py-1 rounded-full text-sm">CSS</span>
                            <span class="bg-yellow-600 px-3 py-1 rounded-full text-sm">JavaScript</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-3">Description</h2>
                        <p class="text-gray-300 leading-relaxed">
                            A comprehensive guide to modern web development practices. This document covers everything from basic HTML structure to advanced JavaScript concepts. Perfect for beginners and intermediate developers looking to enhance their skills.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold mb-3">Learning Objectives</h2>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Understand fundamental web development concepts
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Master HTML5 and CSS3 techniques
                            </li>
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Learn modern JavaScript practices
                            </li>
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
                        link.href = 'path/to/your/document.pdf'; 
                        link.download = 'Web_Development_Guide_2024.pdf';
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
