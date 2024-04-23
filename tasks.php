<?php
include 'connect.php';

$projectName = $_GET['project_name'];
$selectedDate = new MongoDB\BSON\UTCDateTime(strtotime($_GET['selected_date']) * 1000);

$query = [
    'projectName' => $projectName,
    'endDate' => ['$lte' => $selectedDate],
];

$tasks = $collection->find($query);

// Створення масиву для збереження імен завершених завдань
$taskNames = [];
echo "<h2>Completed tasks for project: $projectName on date: {$_GET['selected_date']}</h2>";
echo "<table border='1'>
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Workers</th>
            <th>Manager</th>
        </tr>";
foreach ($tasks as $task) {
    echo "<tr>";
    echo "<td>{$task['taskName']}</td>";
    echo "<td>{$task['description']}</td>";
    echo "<td>" . implode(", ", iterator_to_array($task['workers'])) . "</td>"; // Перетворення в масив перед використанням implode()
    echo "<td>{$task['manager']}</td>";
    echo "</tr>";
    $taskNames[] = $task['taskName']; // Додавання імені завдання до масиву
}
echo "</table>";

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
        var storedResults = JSON.parse(localStorage.getItem('completed_tasks')) || [];

        // Перевіряємо, чи є збережені результати
        if (storedResults.length > 0) {
            // Виводимо результати на сторінці
            var storedResultsDiv = document.getElementById('storedResults');
            for (var i = 0; i < storedResults.length; i++) {
                var project = storedResults[i];
                var paragraph = document.createElement('p');
                paragraph.textContent = "Завершені завдання для проєкту " + project.projectName + " на дату " + project.selectedDate + ": " + project.tasks.join(", ");
                storedResultsDiv.appendChild(paragraph);
            }
        } else {
            // Виводимо повідомлення про відсутність збережених результатів
            var storedResultsDiv = document.getElementById('storedResults');
            storedResultsDiv.textContent = "Немає збережених результатів";
        }
        
        // Тепер додаємо нові дані до існуючих у localStorage
        var newData = {
            projectName: "<?php echo $projectName; ?>",
            selectedDate: "<?php echo $_GET['selected_date']; ?>",
            tasks: <?php echo json_encode($taskNames); ?> // Передача масиву імен завдань
        };
        storedResults.push(newData);
        localStorage.setItem('completed_tasks', JSON.stringify(storedResults));
    </script>
</body>
</html>
