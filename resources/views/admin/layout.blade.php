@extends('layouts.app')

@section('content')

<div class="d-flex">

    {{-- SIDEBAR --}}
    <div class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
        <h4>Admin</h4>

        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link text-white">Dashboard</a>
            </li>

            <li class="nav-item">
                <a href="/admin/forms" class="nav-link text-white">Forms</a>
            </li>

            <li class="nav-item">
                <a href="/admin/users" class="nav-link text-white">Users</a>
            </li>

            <li class="nav-item">
                <a href="/admin/submissions" class="nav-link text-white">Submissions</a>
            </li>

            <li class="nav-item">
                <a href="/admin/import" class="nav-link text-white">Import</a>
            </li>

            <li class="nav-item">
                <a href="/admin/export" class="nav-link text-white">Export</a>
            </li>

            <li class="nav-item mt-3">
                <form method="POST" action="/logout">
                    @csrf
                    <button class="btn btn-danger w-100">Logout</button>
                </form>
            </li>

        </ul>
    </div>

    {{-- CONTENT --}}
    <div class="p-4 w-100">
        @yield('admin-content')
    </div>

</div>

@endsection
