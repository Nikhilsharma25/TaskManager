<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        #searchData {
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
        }
        #tasks-table {
            width: 100%;
            border-collapse: collapse;
        }
        #tasks-table th, #tasks-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        #tasks-table th {
            background-color: #f8f9fa;
        }
        .logout-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Tasks</h1>

        <!-- Create Task Button -->
        <div class="mb-3">
            <a href="{{ route('tasks.create') }}" class="btn btn-success">Create Task</a>
        </div>

        <input type="text" id="searchData" class="form-control" placeholder="Search tasks...">

        <table id="tasks-table" class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th> <!-- Added Actions column -->
                </tr>
            </thead>
            <tbody>
               @foreach ($taskdata as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">Edit</a>

                            <!-- Delete Button (using a form for POST method) -->
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger logout-btn">Logout</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchData').on('input', function () {
                const searchQuery = $(this).val();

                if (searchQuery.length > 0) {
                    $.ajax({
                        url: '/dashboard/gettasksData',
                        method: 'GET',
                        data: {
                            search: searchQuery
                        },
                        success: function(data) {
                            const tableBody = $('#tasks-table tbody');
                            tableBody.empty(); 
                            if (data.length > 0) {
                                $.each(data, function(index, task) {
                                    const row = `
                                        <tr>
                                            <td>${task.title}</td>
                                            <td>${task.description}</td>
                                            <td>
                                                <a href="/tasks/${task.id}/edit" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="/tasks/${task.id}" method="POST" style="display:inline;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    `;
                                    tableBody.append(row);
                                });
                            } else {
                                tableBody.html('<tr><td colspan="3">No tasks found.</td></tr>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching data:', error);
                            alert('There was an error fetching the tasks. Please try again later.');
                        }
                    });
                } else {
                    $('#tasks-table tbody').empty();
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
