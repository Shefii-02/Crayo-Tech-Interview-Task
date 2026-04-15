@extends('admin.layout')

@section('content')

<h2>Import CSV</h2>

@if(session('success'))
<div style="color:green;">{{ session('success') }}</div>
@endif

<form method="POST" action="/admin/import/preview" enctype="multipart/form-data">
    @csrf

    <select name="form_id" required>
        <option value="">Select Form</option>
        @foreach($forms as $form)
            <option value="{{ $form->id }}">{{ $form->title }}</option>
        @endforeach
    </select>

    <input type="file" name="file" required>

    <button>Upload & Preview</button>
</form>

@endsection
