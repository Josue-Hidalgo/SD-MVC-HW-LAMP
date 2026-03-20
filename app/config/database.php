<?php

declare(strict_types=1);

function db(): mysqli
{
    static $conn = null;

    if ($conn instanceof mysqli) {
        return $conn;
    }

    $servername = getenv('DB_HOST') ?: '127.0.0.1';
    $username   = getenv('DB_USER') ?: 'shortapp';
    $password   = getenv('DB_PASS') ?: '';
    $dbname     = getenv('DB_NAME') ?: 'short_url_db';
    $port       = (int)(getenv('DB_PORT') ?: 3306);

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        throw new RuntimeException("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
    return $conn;
}