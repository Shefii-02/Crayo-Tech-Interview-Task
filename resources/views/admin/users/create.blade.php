@extends('admin.layout')

@section('admin-content')

<div class="container mt-4">
    <h2>Create User</h2>


<div class="card mt-3">
    <div class="card-body">

        <form method="POST" action="/admin/users">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button class="btn btn-success">Save</button>
            <a href="/admin/users" class="btn btn-secondary">Back</a>

        </form>

    </div>
</div>


</div>

@endsection
