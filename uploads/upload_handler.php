<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create uploads folder if not exists
$uploadDir = __DIR__ . '/uploads/';
$videosDir = $uploadDir . 'videos/';
$thumbnailsDir = $uploadDir . 'thumbnails/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
if (!file_exists($videosDir)) {
    mkdir($videosDir, 0777, true);
}
if (!file_exists($thumbnailsDir)) {
    mkdir($thumbnailsDir, 0777, true);
}

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $uploaderName = $_POST['uploaderName'] ?? '';
    $category = $_POST['category'] ?? 'Other';
    
    if (empty($title) || empty($uploaderName)) {
        $response['message'] = 'Title and uploader name are required';
        echo json_encode($response);
        exit;
    }
    
    // Check if video file is uploaded
    if (!isset($_FILES['video']) || $_FILES['video']['error'] !== UPLOAD_ERR_OK) {
        $errorMsg = '';
        if (isset($_FILES['video']['error'])) {
            switch ($_FILES['video']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    $errorMsg = 'File is too large (max 128MB)';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $errorMsg = 'File is too large';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errorMsg = 'No file was uploaded';
                    break;
                default:
                    $errorMsg = 'Unknown upload error';
            }
        }
        $response['message'] = $errorMsg ?: 'Video file is required';
        echo json_encode($response);
        exit;
    }
    
    // Handle video upload
    $videoUrl = '';
    $videoExt = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
    $allowedVideoExt = ['mp4', 'webm', 'mkv', 'avi', 'mov'];
    
    if (!in_array($videoExt, $allowedVideoExt)) {
        $response['message'] = 'Only MP4, WebM, MKV, AVI, MOV files are allowed';
        echo json_encode($response);
        exit;
    }
    
    $videoName = time() . '_' . uniqid() . '.' . $videoExt;
    $videoPath = $videosDir . $videoName;
    
    if (move_uploaded_file($_FILES['video']['tmp_name'], $videoPath)) {
        $videoUrl = 'uploads/videos/' . $videoName;
    } else {
        $response['message'] = 'Failed to upload video file. Check folder permissions.';
        echo json_encode($response);
        exit;
    }
    
    // Handle thumbnail upload (optional)
    $thumbnailUrl = '';
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $thumbExt = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
        $allowedImageExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($thumbExt, $allowedImageExt)) {
            $thumbName = time() . '_thumb_' . uniqid() . '.' . $thumbExt;
            $thumbPath = $thumbnailsDir . $thumbName;
            
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbPath)) {
                $thumbnailUrl = 'uploads/thumbnails/' . $thumbName;
            }
        }
    }
    
    // Get duration (simple estimation if FFmpeg not available)
    $duration = '00:00';
    if (function_exists('shell_exec')) {
        $ffmpegCmd = 'ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 "' . $videoPath . '" 2>&1';
        $durationSec = shell_exec($ffmpegCmd);
        if ($durationSec && is_numeric(trim($durationSec))) {
            $durationSec = round(trim($durationSec));
            $hours = floor($durationSec / 3600);
            $minutes = floor(($durationSec % 3600) / 60);
            $seconds = $durationSec % 60;
            $duration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        }
    }
    
    // Get existing videos from JSON file
    $videosFile = __DIR__ . '/videos.json';
    $videos = [];
    
    if (file_exists($videosFile)) {
        $content = file_get_contents($videosFile);
        $videos = json_decode($content, true);
        if (!is_array($videos)) $videos = [];
    }
    
    // Create new video object
    $newVideo = [
        'id' => time(),
        'title' => $title,
        'description' => $description,
        'uploaderName' => $uploaderName,
        'category' => $category,
        'videoUrl' => $videoUrl,
        'thumbnail' => $thumbnailUrl ?: 'https://via.placeholder.com/400x225?text=Video+Thumbnail',
        'views' => 0,
        'date' => date('c'),
        'duration' => $duration
    ];
    
    // Add to videos array (newest first)
    array_unshift($videos, $newVideo);
    
    // Save to JSON file
    if (file_put_contents($videosFile, json_encode($videos, JSON_PRETTY_PRINT))) {
        $response['success'] = true;
        $response['message'] = 'Video uploaded successfully!';
        $response['video'] = $newVideo;
    } else {
        $response['message'] = 'Video uploaded but failed to save data. Please check folder permissions.';
    }
    
    echo json_encode($response);
} else {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
}
?>