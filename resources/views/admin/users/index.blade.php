@extends('admin.layout')

@section('admin-content')

<div class="container mt-4">


<div class="d-flex justify-content-between mb-3">
    <h2>Users</h2>
    <a href="/admin/users/create" class="btn btn-primary">+ Add User</a>
</div>

<div class="card">
    <div class="card-body p-0">

        <table class="table table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th width="80">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>

                            <a href="/admin/users/{{ $user->id }}/edit"
                               class="btn btn-sm btn-warning">
                               Edit
                            </a>

                            <form method="POST"
                                  action="/admin/users/{{ $user->id }}"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this user?')">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No users found</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

<div class="mt-3">
    {{ $users->links('pagination::bootstrap-5') }}
</div>


</div>

@endsection
