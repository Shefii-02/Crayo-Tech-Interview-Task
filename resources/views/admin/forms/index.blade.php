@extends('admin.layout')

@section('content')

<h1 class="text-xl mb-4">Forms</h1>

<a href="/admin/forms/create" class="bg-blue-500 text-white px-4 py-2">Create Form</a>

<table class="w-full mt-4 bg-white shadow">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Action</th>
    </tr>

    @foreach($forms as $form)
    <tr>
        <td>{{ $form->id }}</td>
        <td>{{ $form->title }}</td>
        <td>
            <form method="POST" action="/admin/forms/{{ $form->id }}">
                @csrf
                @method('DELETE')
                <button class="text-red-500">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $forms->links() }}

@endsection
