<?php

// Mematikan semua peringatan deprecated sebelum memuat Laravel
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '0');

require __DIR__ . '/../public/index.php';