<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Assigned</title>
</head>
<body>
    <h1>Task Assigned: {{ $task->title }}</h1>
    <p>Description: {{ $task->description }}</p>
    <p>Due Date: {{ $task->due_date }}</p>
    <p>Status: {{ $task->status }}</p>
</body>
</html>
