<?php
$data = file_get_contents('php://input');
$jsonData = json_decode($data);


$logFolderPath = UPLOAD_BASE .'srolog';
$logFilePath = $logFolderPath . '/log.txt';

// Check if log folder exists, create it if not
if (!is_dir($logFolderPath)) {
    mkdir($logFolderPath);
}


// Check if log.txt file already exists
if (!file_exists($logFilePath)) {
  // Create log.txt file if it doesn't exist
  $file = fopen($logFilePath, 'w');
  if ($file) {
    fclose($file);
  } else {
    http_response_code(500); // Internal Server Error
    echo 'Failed to create log file.';
    exit;
  }
}

// Append jsonData to log.txt file on a new line
$file = fopen($logFilePath, 'a');
if ($file) {
  fwrite($file, json_encode($jsonData) . "\n"); // Append jsonData on a new line
  fclose($file);
  http_response_code(200); // OK
  echo 'Data appended to log file successfully.';
} else {
  http_response_code(500); // Internal Server Error
  echo 'Failed to write to log file.';
}