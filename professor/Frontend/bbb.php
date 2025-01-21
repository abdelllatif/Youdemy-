<?php
require_once '../../classes/class_course_content.php';
require_once '../../professor/Backend/get_all_tags.php';
require_once '../../professor/Backend/get_all_categorie.php';
$video_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$videoHandler = new VideoHandler();
$video = $videoHandler->afficherbyid($video_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Video</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white">
<div class="container mx-auto px-4 py-8">
<div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow-xl p-6">
<div class="flex justify-between items-center mb-6">
<h2 class="text-2xl font-bold">Edit Video</h2>
<a href="videos.php" class="text-gray-400 hover:text-white">
<i class="fas fa-times text-xl"></i>
</a>
</div>

<form id="editVideoForm" action="../Backend/update_video.php" class="space-y-6" method="POST" enctype="multipart/form-data">
<input type="hidden" name="video_id" value="<?php echo htmlspecialchars($video_id); ?>">

<!-- Title -->
<div>
<label class="block text-sm font-medium text-gray-300 mb-2">Video Title</label>
<input type="text" name="title" value="<?php echo htmlspecialchars($video['title'] ?? ''); ?>"
class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" required>
</div>

<!-- Video File -->
<div>
<label class="block text-sm font-medium text-gray-300 mb-2">Video File</label>
<div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center">
<input type="file" name="video" accept="video/*" class="hidden" id="videoUpload">
<label for="videoUpload" class="cursor-pointer">
<i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
<p class="text-gray-400">Click to upload new video (optional)</p>
<?php if (!empty($video['video_path'])): ?>
<p class="text-sm text-gray-500">Current: <?php echo basename($video['video_path']); ?></p>
<?php endif; ?>
</label>
</div>
</div>


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




<select name="categorie" id="videoCategorySelect" class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2">
    <option value="" disabled>Select category</option>
    <?php 
    $selectedCategory = isset($video['categories'][0]['id']) ? $video['categories'][0]['id'] : ''; 
    foreach($result as $category): 
    ?>
        <option value="<?php echo htmlspecialchars($category['id']); ?>" 
            <?php echo ($category['id'] == $selectedCategory) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($category['name']); ?>
        </option>
    <?php endforeach; ?>
</select>



<!-- Tags -->
<div id="tagsContainer">
<label class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
<div class="flex flex-wrap gap-2 mb-2">
<?php if(isset($video['tags'])): ?>
<?php foreach($video['tags'] as $tag): ?>
<span class="bg-blue-500 px-2 py-1 rounded-full text-sm flex items-center">
<?php echo htmlspecialchars($tag['name']); ?>
<button type="button" class="ml-2" onclick="removeItem(this, 'tag')">
<i class="fas fa-times"></i>
</button>
<input type="hidden" name="tags[]" value="<?php echo $tag['id']; ?>" class="tagInput">
</span>
<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="flex gap-2">
<select id="videoTAGSelect" name="tags[]" class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" multiple>
<option value="" disabled selected>Select tag</option>
<?php foreach($result2 as $tag): ?>
<option value="<?php echo htmlspecialchars($tag['id']); ?>"><?php echo htmlspecialchars($tag['name']); ?></option>
<?php endforeach; ?>
</select>
<button type="button" onclick="addTag()"
class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
Add Tag
</button>
</div>
</div>

<!-- Learning Objectives -->
<div id="learningContainer">
<label class="block text-sm font-medium text-gray-300 mb-2">Learning Objectives</label>
<div class="flex flex-wrap gap-2 mb-2">
<?php if(isset($video['learning'])): ?>
<?php foreach($video['learning'] as $learning): ?>
<span class="bg-purple-500 px-2 py-1 rounded-full text-sm flex items-center">
<?php echo htmlspecialchars($learning); ?>
<button type="button" class="ml-2" onclick="removeItem(this, 'learning')">
<i class="fas fa-times"></i>
</button>
<input type="hidden" name="learning[]" value="<?php echo htmlspecialchars($learning); ?>" class="learningInput">
</span>
<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="flex gap-2">
<input type="text" id="learningInput" class="flex-1 rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2" placeholder="Add learning objective">
<button type="button" onclick="addLearningObjective()"
class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
Add Learning
</button>
</div>
</div>

<!-- Description -->
<div>
<label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
<textarea name="description" rows="4"
class="w-full rounded-md bg-gray-700 border-gray-600 text-white px-4 py-2"
required><?php echo htmlspecialchars($video['description'] ?? ''); ?></textarea>
</div>

<!-- Submit Buttons -->
<div class="flex justify-end gap-3">
<a href="videos.php" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">Cancel</a>
<button type="submit" name="update" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
Save Changes
</button>
</div>
</form>
</div>
</div>


    <script>
        function removeItem(button) {
            button.parentElement.remove();
        }

// Add Tag
function addTag() {
    const select = document.getElementById("videoTAGSelect");
    const tagId = select.value;
    const tagName = select.options[select.selectedIndex].text;

    if (tagId) {
        // Create the tag span
        const tagSpan = document.createElement("span");
        tagSpan.classList.add("bg-blue-500", "px-2", "py-1", "rounded-full", "text-sm", "flex", "items-center");
        
        // Add the tag name
        tagSpan.innerHTML = `${tagName} <button type="button" class="ml-2" onclick="removeTag(this, ${tagId})"><i class="fas fa-times"></i></button>`;
        
        // Create a hidden input to store the tag ID
        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "tags[]";
        hiddenInput.value = tagId;
        
        // Append the input and tag span
        tagSpan.appendChild(hiddenInput);
        
        // Add the tag span to the container
        document.getElementById("tagsContainer").appendChild(tagSpan);
    }
}

// Remove Tag
function removeTag(button, tagId) {
    button.parentElement.remove();
    // Optionally, you could also remove the hidden input from the tags[] array
    const hiddenInputs = document.querySelectorAll(`input[value='${tagId}']`);
    hiddenInputs.forEach(input => input.remove());
}


// Remove Category
function removeCategory(button, categoryId) {
    button.parentElement.remove();
    // Optionally, you could also remove the hidden input from the categories[] array
    const hiddenInputs = document.querySelectorAll(`input[value='${categoryId}']`);
    hiddenInputs.forEach(input => input.remove());
}

// Add Learning Objective
function addLearningObjective() {
    const input = document.getElementById("videoObjectiveInput");
    const learningObjective = input.value.trim();

    if (learningObjective) {
        // Create the learning objective span
        const learningSpan = document.createElement("span");
        learningSpan.classList.add("bg-purple-500", "px-2", "py-1", "rounded-full", "text-sm", "flex", "items-center");
        
        // Add the learning objective text
        learningSpan.innerHTML = `${learningObjective} <button type="button" class="ml-2" onclick="removeLearningObjective(this)"><i class="fas fa-times"></i></button>`;
        
        // Create a hidden input to store the learning objective
        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "learning[]";
        hiddenInput.value = learningObjective;
        
        // Append the input and learning span
        learningSpan.appendChild(hiddenInput);
        
        // Add the learning objective span to the container
        document.getElementById("learningContainer").appendChild(learningSpan);

        // Clear the input field
        input.value = '';
    }
}

// Remove Learning Objective
function removeLearningObjective(button) {
    button.parentElement.remove();
    // Optionally, you could also remove the hidden input from the learning[] array
    const hiddenInputs = document.querySelectorAll(`input[value='${button.parentElement.textContent.trim()}']`);
    hiddenInputs.forEach(input => input.remove());
}

</script>

</body>
</html>