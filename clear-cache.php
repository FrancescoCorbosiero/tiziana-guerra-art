<?php
/**
 * Cache Clearing Script
 * Run this by visiting: yourdomain.com/wp-content/themes/sage/clear-cache.php
 */

// Security: Only allow local requests or add your IP
$allowed_ips = ['127.0.0.1', '::1', 'localhost'];
$client_ip = $_SERVER['REMOTE_ADDR'] ?? '';

if (!in_array($client_ip, $allowed_ips) && !isset($_GET['force'])) {
    die('Access denied. Run from localhost or add ?force=1');
}

echo '<h1>Clearing Sage/Acorn Cache...</h1>';

// Clear Blade view cache
$view_cache_path = __DIR__ . '/../../cache/acorn/framework/views/';
if (is_dir($view_cache_path)) {
    $files = glob($view_cache_path . '*');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            $count++;
        }
    }
    echo "<p>✅ Cleared {$count} compiled Blade view files</p>";
} else {
    echo "<p>⚠️ Blade cache directory not found at: {$view_cache_path}</p>";
}

// Clear Acorn bootstrap cache
$bootstrap_cache = __DIR__ . '/../../cache/acorn/framework/cache.php';
if (file_exists($bootstrap_cache)) {
    unlink($bootstrap_cache);
    echo "<p>✅ Cleared bootstrap cache</p>";
}

// Clear other Acorn caches
$acorn_cache_dirs = [
    __DIR__ . '/../../cache/acorn/framework/cache/',
    __DIR__ . '/../../cache/acorn/framework/config/',
    __DIR__ . '/../../cache/acorn/framework/routes/',
];

foreach ($acorn_cache_dirs as $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '*');
        $count = 0;
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                $count++;
            }
        }
        if ($count > 0) {
            echo "<p>✅ Cleared {$count} files from " . basename($dir) . "</p>";
        }
    }
}

echo '<hr>';
echo '<p><strong>Cache cleared! Refresh your site now.</strong></p>';
echo '<p><a href="' . home_url() . '">← Go to Homepage</a></p>';
