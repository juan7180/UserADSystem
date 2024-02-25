<?php
$directory = __DIR__;

$files = scandir($directory);

$mediaFiles = array_filter($files, function($file) use ($directory) {
    $filePath = $directory . DIRECTORY_SEPARATOR . $file;
    return is_file($filePath) && preg_match('/\.(jpg|jpeg|png|gif|mp4|avi|mov)$/i', $file);
});

$randomMediaFile = $mediaFiles[array_rand($mediaFiles)];

$mediaFilePath = $directory . DIRECTORY_SEPARATOR . $randomMediaFile;

$mime_type = mime_content_type($mediaFilePath);

header('Content-type: ' . $mime_type);
readfile($mediaFilePath);
?>
