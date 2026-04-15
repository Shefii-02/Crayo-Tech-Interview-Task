@extends('admin.layout')

@section('admin-content')

<h2 class="mb-3">Forms</h2>

<a href="/admin/forms/create" class="btn btn-primary mb-3">Create Form</a>

<table class="table table-bordered">

    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($forms as $form)
    <tr>
        <td>{{ $form->id }}</td>
        <td>{{ $form->title }}</td>
        <td>{{ $form->status ? 'Active' : 'Inactive' }}</td>
        <td>
            <a href="/admin/forms/{{ $form->id }}" class="btn btn-info btn-sm">View</a>
            <a href="/admin/forms/{{ $form->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('forms.destroy', $form->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection
