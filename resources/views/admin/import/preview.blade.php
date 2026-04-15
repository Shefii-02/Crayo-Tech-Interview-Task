@extends('admin.layout')

@section('content')

<h2>Preview</h2>

<h3>Valid Rows</h3>
@foreach($valid as $row)
    <div>{{ implode(', ', $row) }}</div>
@endforeach

<h3>Invalid Rows</h3>
@foreach($invalid as $row)
    <div>Row {{ $row['row'] }} - {{ implode(', ', $row['errors']) }}</div>
@endforeach

<form method="POST" action="/admin/import/store">
    @csrf

    <input type="hidden" name="form_id" value="{{ $form_id }}">
    <input type="hidden" name="valid_data" value="{{ json_encode($valid) }}">

    <button>Confirm Import</button>
</form>

@endsection
