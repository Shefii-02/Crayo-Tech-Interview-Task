@extends('admin.layout')

@section('content')

<h2>Export</h2>

<form method="GET" action="/admin/export/download">

    <select name="form_id" required>
        @foreach($forms as $form)
            <option value="{{ $form->id }}">{{ $form->title }}</option>
        @endforeach
    </select>

    <button>Download CSV</button>

</form>

@endsection
