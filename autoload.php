<?php
spl_autoload_register(function ($class) {
    // Prefix for PhpSpreadsheet
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    
    // Adjust the base directory path to where PhpSpreadsheet is uploaded
    // Assuming you placed the PhpSpreadsheet folder directly in the root of your project
    $base_dir = __DIR__ . '/PhpSpreadsheet-master/';  // Adjust this path if PhpSpreadsheet is in another directory

    // Check if the class uses the PhpSpreadsheet prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) === 0) {
        // Get the relative class name
        $relative_class = substr($class, $len);
        // Replace namespace separators with directory separators
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        // Include the file if it exists
        if (file_exists($file)) {
            require $file;
        }
        return;
    }

    // Prefix for PSR SimpleCache
    $prefixPsr = 'Psr\\SimpleCache\\';
    
    // Adjust the base directory path for PSR SimpleCache
    // Assuming you placed the simple-cache folder in the root directory
    $base_dir_psr = __DIR__ . '/psr/simple-cache/'; // Adjust this path if placed in another directory

    $len_psr = strlen($prefixPsr);
    if (strncmp($prefixPsr, $class, $len_psr) === 0) {
        // Get the relative class name for PSR SimpleCache
        $relative_class_psr = substr($class, $len_psr);
        $file_psr = $base_dir_psr . str_replace('\\', '/', $relative_class_psr) . '.php';
        if (file_exists($file_psr)) {
            require $file_psr;
        }
    }
});
