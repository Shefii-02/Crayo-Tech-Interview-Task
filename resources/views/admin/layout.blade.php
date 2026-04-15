<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 text-white min-h-screen p-4">
        <h2 class="text-xl font-bold mb-6">Admin</h2>

        <ul class="space-y-3">
            <li><a href="/admin/dashboard">Dashboard</a></li>
            <li><a href="/admin/forms">Forms</a></li>
            <li><a href="/admin/users">Users</a></li>
            <li><a href="/admin/submissions">Submissions</a></li>
            <li><a href="/admin/import">Import</a></li>
            <li><a href="/admin/export">Export</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="flex-1 p-6">
        @yield('content')
    </div>

</div>

</body>
</html>
