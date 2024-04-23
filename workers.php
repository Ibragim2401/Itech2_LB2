<?php
include 'connect.php'; // Підключіть файл для доступу до бази даних

// Отримання даних зі списку вибору
$manager_name = $_GET['manager_name']; // Ми передаємо дані методом GET

try {
    // Запит до бази даних MongoDB
    $result = $collection->aggregate([
        ['$match' => ['manager' => $manager_name]], // Фільтруємо записи за ім'ям менеджера
        ['$unwind' => '$workers'], // Розгортаємо масив працівників
        ['$group' => [
            '_id' => '$manager', 
            'total_workers' => ['$addToSet' => '$workers'] // Збираємо унікальні імена працівників
        ]]
    ]);

    // Перевірка наявності результатів
    if ($result) {
        $data = iterator_to_array($result);

        foreach ($data as $row) {
            $totalWorkers = count($row['total_workers']);
            echo "Кількість унікальних працівників під керівництвом " . $row['_id'] . ": " . $totalWorkers;
        }
    } else {
        echo "Немає даних для виведення";
    }

} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stored Results</title>
</head>
<body>
    <h2>Stored Results</h2>
    
    <div id="storedResults"></div>

    <script>
        // Отримуємо дані з localStorage
        var storedResults = JSON.parse(localStorage.getItem('query_results')) || [];

        // Перевіряємо, чи є збережені результати
        if (storedResults.length > 0) {
            // Виводимо результати на сторінці
            var storedResultsDiv = document.getElementById('storedResults');
            for (var i = 0; i < storedResults.length; i++) {
                var row = storedResults[i];
                var totalWorkers = row.total_workers.length;
                var paragraph = document.createElement('p');
                paragraph.textContent = "Кількість унікальних працівників під керівництвом " + row._id + ": " + totalWorkers;
                storedResultsDiv.appendChild(paragraph);
            }
        } else {
            // Виводимо повідомлення про відсутність збережених результатів
            var storedResultsDiv = document.getElementById('storedResults');
            storedResultsDiv.textContent = "Немає збережених результатів";
        }
        
        // Тепер додаємо нові дані до існуючих у localStorage
        var newData = <?php echo json_encode($data); ?>;
        var combinedData = storedResults.concat(newData);
        localStorage.setItem('query_results', JSON.stringify(combinedData));
    </script>
</body>
</html>
