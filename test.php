<?php
// Simple test file to check theme loading
echo "Theme test file loaded successfully!";
echo "<br>PHP version: " . phpversion();
echo "<br>WordPress functions available: " . (function_exists('wp_enqueue_style') ? 'Yes' : 'No');
echo "<br>WooCommerce available: " . (class_exists('WooCommerce') ? 'Yes' : 'No');
?>
