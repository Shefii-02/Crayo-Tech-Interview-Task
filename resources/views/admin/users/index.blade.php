@extends('admin.layout')

@section('content')

<h2>Users</h2>

<table class="w-full bg-white shadow mt-4">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

@foreach($users as $user)
<tr>
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
        <form method="POST" action="/admin/users/{{ $user->id }}">
            @csrf
            @method('DELETE')
            <button class="text-red-500">Delete</button>
        </form>
    </td>
</tr>
@endforeach

</table>

{{ $users->links() }}

@endsection
