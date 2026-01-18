<?php

// Vercel serverless handler untuk Laravel
// Definisikan LARAVEL_START untuk Laravel bootstrapping
define('LARAVEL_START', microtime(true));

// Bootstrap Laravel application
require __DIR__ . '/../public/index.php';
