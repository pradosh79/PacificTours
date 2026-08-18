<?php
/**
 * One-time storage:link replacement for shared hosting.
 * Delete this file immediately after running it.
 */

$target = realpath(__DIR__ . '/../storage/app/public');
$link   = __DIR__ . '/storage';

if (!$target) {
    exit('ERROR: storage/app/public folder is missing. Create it first.');
}

if (file_exists($link) || is_link($link)) {
    exit('The link at public/storage already exists. Nothing to do.');
}

if (@symlink($target, $link)) {
    echo 'SUCCESS — symlink created. Reload your image URL to confirm.<br>';
    echo 'DELETE THIS FILE NOW: public/create-storage-link.php';
    exit;
}

// Fallback for hosts that block symlink(): mirror the folder as a real directory.
echo 'symlink() blocked by host — falling back to copy…<br>';

function mirror(string $src, string $dst): void {
    @mkdir($dst, 0755, true);
    foreach (scandir($src) as $item) {
        if ($item === '.' || $item === '..') continue;
        $s = "$src/$item"; $d = "$dst/$item";
        is_dir($s) ? mirror($s, $d) : copy($s, $d);
    }
}

mirror($target, $link);
echo 'Copy complete. Reload your image URL to confirm.<br>';
echo 'IMPORTANT: fix your config so new uploads land in public/storage directly — see instructions.<br>';
echo 'DELETE THIS FILE NOW.';