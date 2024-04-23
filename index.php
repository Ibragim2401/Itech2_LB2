<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work</title>
    <style>
        header 
        {
            background-color:antiquewhite ;
            padding: 1rem;
            text-align: center;
            color: black;
        }

        .container
        {
            display: flex;
            justify-content: space-between;
            border: 3px solid #ccc;
            padding: 20px;
            margin-top: 30px;
        }

        .tasks
        {
            width: 500px;
            height: 300px;
            background-color: antiquewhite;
            margin: 10px;
            font-size: 20px;
            text-align: center;
        }

        .button {
            padding: 10px 20px;
            background-color: chocolate;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <h1>Лабораторна робота №2</h1>
    </header>
    <div class="container">
        <div class="tasks">
            <p style="padding-top: 20px;">The number of subordinates of each chief</p>
            <form action="workers.php" method="get">
            <label for="name">Chief name: </label>
            <select id="name" name="manager_name">
                <option value="Jobs">Jobs</option>
                <option value="Vozniak">Vozniak</option>
            </select>
            <button type="submit" class="button">Enter</button>
            </form>
        </div>
        <div class="tasks">
            <p style="padding-top: 20px;">The number of projects of the selected chief</p>
            <form action="projects.php" method="get">
            <label for="name">Chief name: </label>
            <select id="name" name="manager_name">
                <option value="Jobs">Jobs</option>
                <option value="Vozniak">Vozniak</option>
            </select>
            <button type="submit" class="button">Enter</button>
            </form>
        </div>
        <div class="tasks">
            <p style="padding: 20px 10px;">Infos on completed tasks for the specified project 
                on the selected date</p>
            <form action="tasks.php" method="get">
            <label for="project">Project name:</label>
            <select id="project" name="project_name">
                <option value="Bank">Bank</option>
                <option value="Hospital">Hospital</option>
            </select><br>
            <label for="dateInput">Enter date:</label>
            <input type="date" id="dateInput" name="selected_date"><br><br>
            <input type="submit" value="Enter" class="button">
            </form>
        </div>
    </div>
</body>

</html>