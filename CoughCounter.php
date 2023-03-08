<?php

require_once 'login.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname")
}