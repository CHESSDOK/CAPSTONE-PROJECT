<?php
$file = $_GET['file_path'];
// Serve the document with appropriate headers to force viewing in the browser
$file_path = '../../php/applicant/resume/'.$file;

$file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
if ($file_extension == 'doc' || $file_extension == 'docx') {
    // Redirect to Microsoft Office Web Viewer
    $document_url = 'http://localhost/wakey/php/applicant/"'.$file.'"';
    header('Location: https://docs.google.com/viewer?src=' . urlencode($document_url));
    exit;
}
// Set the appropriate headers based on file extension
switch ($file_extension) {
    case 'pdf':
        header('Content-Type: application/pdf');
        break;
    case 'jpg':
    case 'jpeg':
        header('Content-Type: image/jpeg');
        break;
    case 'png':
        header('Content-Type: image/png');
        break;
    case 'txt':
        header('Content-Type: text/plain');
        break;
    // Add more file types as needed
}

// Send the file to the browser
readfile($file_path);
exit;
?>