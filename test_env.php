<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "SMTP Host: " . $_ENV['SMTP_HOST'] . "<br>";
echo "SMTP Username: " . $_ENV['SMTP_USERNAME'] . "<br>";
echo "SMTP From: " . $_ENV['SMTP_FROM'] . "<br>";