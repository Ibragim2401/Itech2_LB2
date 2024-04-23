<?php
include 'connect.php'; // Підключіть файл для доступу до бази даних

// Отримання параметра manager_name з URL-запиту
$managerName = $_GET['manager_name'];

// Запит до бази даних для підрахунку кількості проєктів для обраного керівника
$result = $collection->countDocuments(['manager' => $managerName]);

// Виведення результату
echo "Кількість проєктів для керівника $managerName: $result";
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
        var storedResults = JSON.parse(localStorage.getItem('project_results')) || [];

        // Перевіряємо, чи є збережені результати
        if (storedResults.length > 0) {
            // Виводимо результати на сторінці
            var storedResultsDiv = document.getElementById('storedResults');
            for (var i = 0; i < storedResults.length; i++) {
                var project = storedResults[i];
                var paragraph = document.createElement('p');
                paragraph.textContent = "Кількість проєктів для керівника " + project.manager + ": " + project.count;
                storedResultsDiv.appendChild(paragraph);
            }
        } else {
            // Виводимо повідомлення про відсутність збережених результатів
            var storedResultsDiv = document.getElementById('storedResults');
            storedResultsDiv.textContent = "Немає збережених результатів";
        }
        
        // Тепер додаємо нові дані до існуючих у localStorage
        var newData = { manager: "<?php echo $managerName; ?>", count: "<?php echo $result; ?>" };
        storedResults.push(newData);
        localStorage.setItem('project_results', JSON.stringify(storedResults));
    </script>
</body>
</html>
