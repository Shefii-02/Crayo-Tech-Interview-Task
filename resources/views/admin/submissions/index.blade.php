@extends('admin.layout')

@section('content')

<h2>Submissions</h2>

<form method="GET">
    <select name="form_id">
        <option value="">All Forms</option>
        @foreach(\App\Models\Form::all() as $form)
            <option value="{{ $form->id }}">
                {{ $form->title }}
            </option>
        @endforeach
    </select>

    <button>Filter</button>
</form>

<table class="w-full bg-white shadow mt-4">
<tr>
    <th>ID</th>
    <th>Form</th>
    <th>Action</th>
</tr>

@foreach($submissions as $sub)
<tr>
    <td>{{ $sub->id }}</td>
    <td>{{ $sub->form->title ?? '' }}</td>
    <td>
        <form method="POST" action="/admin/submissions/{{ $sub->id }}">
            @csrf
            @method('DELETE')
            <button class="text-red-500">Delete</button>
        </form>
    </td>
</tr>
@endforeach

</table>

{{ $submissions->links() }}

@endsection
