<?php

spl_autoload_register(function ($class) {
    // PhpSpreadsheet base directory
    $baseDir = __DIR__ . '\libs\PhpSpreadsheet-1.25.2\src';

    // Check if the class uses the PhpSpreadsheet namespace
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    
    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // Move to the next registered autoloader if the class does not use the PhpSpreadsheet prefix
        return;
    }

    // Get the relative class name
    $relativeClass = substr($class, $len);

    // Replace the namespace prefix with the base directory, replace namespace separators with directory separators
    // and append with .php
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
