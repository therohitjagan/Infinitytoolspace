<?php
/**
 * Cleanup Script
 * Deletes files older than 1 hour from the uploads and converted directories
 */

$dirs = ['uploads/', 'converted/'];
$maxAge = 3600; // 1 hour in seconds
$now = time();
$totalDeleted = 0;

foreach ($dirs as $dir) {
    if (!file_exists($dir)) {
        echo "Directory not found: $dir\n";
        continue;
    }

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..' || substr($item, 0, 1) === '.') {
            continue;
        }

        $path = $dir . $item;

        if (is_file($path) && ($now - filemtime($path) > $maxAge)) {
            if (unlink($path)) $totalDeleted++;
        } elseif (is_dir($path) && ($now - filemtime($path) > $maxAge)) {
            $files = glob("$path/*");
            foreach ($files as $f) {
                if (is_file($f)) {
                    if (unlink($f)) $totalDeleted++;
                }
            }
            if (rmdir($path)) $totalDeleted++;
        }
    }
}

echo "Cleanup completed. Removed $totalDeleted item(s).\n";
?>
