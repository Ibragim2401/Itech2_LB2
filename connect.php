<?php
try {
    require 'vendor/autoload.php'; // Завантажте автозавантажувач Composer
    
    // Підключення до MongoDB
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");

    $collection = $mongoClient->dbforlab->tasks;

} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Помилка підключення до бази даних: " . $e->getMessage();
}
?>
