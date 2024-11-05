<?php
$host = 'smtp.gmail.com';
$port = 587;
$timeout = 10;
$socket = fsockopen($host, $port, $errno, $errstr, $timeout);

if (!$socket) {
    echo "Failed to connect: $errstr ($errno)";
} else {
    echo "Connected successfully.";
    fclose($socket);
}
?>
