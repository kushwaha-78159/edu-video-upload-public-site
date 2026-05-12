<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$videosFile = 'videos.json';

if (file_exists($videosFile)) {
    $content = file_get_contents($videosFile);
    $videos = json_decode($content, true);
    echo json_encode($videos ?: []);
} else {
    echo json_encode([]);
}
?>