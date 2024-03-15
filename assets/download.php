<?php
function getMimeType($ext) {
    $mimeTypes = [
        'mp3' => 'audio/mpeg',
        'pdf' => 'application/pdf',
        'cdr' => 'application/cdr',
        'gif' => 'image/gif',
        'zip' => 'application/zip',
        'rar' => 'application/rar',
        'sql' => 'application/sql',
        'jpg' => 'image/jpeg',
        'jepg' => 'image/jpeg',
        'ai' => 'application/postscript',
        'psd' => 'image/vnd.adobe.photoshop',
        'xml' => 'application/xml',
        'doc' => 'application/msword',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pps' => 'application/vnd.ms-powerpoint'
    ];

    return array_key_exists($ext, $mimeTypes) ? $mimeTypes[$ext] : 'application/octet-stream';
}

if (isset($_GET['arquivo']) && is_file($_GET['arquivo'])) {
    $file = $_GET['arquivo'];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $mimeType = getMimeType($ext);

    header('Content-Type: ' . $mimeType);
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    readfile($file);
    exit;
} else {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    header("Status: 404 Not Found");
    die("File not found");
}
