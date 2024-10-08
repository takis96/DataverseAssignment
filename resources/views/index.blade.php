<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create User</h2>
        <form id="createUserForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>

        <h2 class="mt-5">Users List</h2>
        <table id="usersTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data loaded by AJAX -->
            </tbody>
        </table>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        // Create User AJAX Form Submission
        $('#createUserForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('users.store') }}",
                method: "POST",
                dataType: "json",
                contentType: "application/json",
                data: JSON.stringify({
                    name: $('#name').val(),
                    username: $('#username').val(),
                    password: $('#password').val(),
                    _token: '{{ csrf_token() }}'
                }),
                success: function(response) {
                    alert('User created successfully');
                    $('#usersTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    alert('Error creating user: ' + xhr.responseJSON.message);
                }
            });
        });

        // Initialize DataTables with AJAX
        $('#usersTable').DataTable({
            ajax: '{{ route("users.index") }}',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'username' },
                { data: 'roles[0].name' },
                {
                    data: null,
                    render: function(data) {
                        return `
                            <a href="/users/${data.id}/edit" class="btn btn-warning">Edit</a>
                            <form method="POST" action="/users/${data.id}" style="display:inline" class="deleteUserForm">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>`;
                    }
                }
            ]
        });
    </script>
</body>
</html>
