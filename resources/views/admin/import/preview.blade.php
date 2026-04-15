@extends('admin.layout')

@section('admin-content')

<div class="container mt-4">


<h2 class="mb-4">Import Preview</h2>

{{-- VALID ROWS --}}
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        Valid Rows ({{ count($valid) }})
    </div>

    <div class="card-body">

        @forelse($valid as $row)
            <div class="border rounded p-2 mb-2 bg-light">
                {{ implode(', ', $row) }}
            </div>
        @empty
            <div class="text-muted">No valid rows</div>
        @endforelse

    </div>
</div>

{{-- INVALID ROWS --}}
<div class="card mb-4">
    <div class="card-header bg-danger text-white">
        Invalid Rows ({{ count($invalid) }})
    </div>

    <div class="card-body">

        @forelse($invalid as $row)
            <div class="border rounded p-2 mb-2">

                <strong class="text-danger">
                    Row {{ $row['row'] }}
                </strong>

                <ul class="mb-0 mt-1">
                    @foreach($row['errors'] as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @empty
            <div class="text-muted">No invalid rows 🎉</div>
        @endforelse

    </div>
</div>

{{-- ACTION --}}
<div class="card">
    <div class="card-body text-center">

        <form method="POST" action="/admin/import/store">
            @csrf

            <input type="hidden" name="form_id" value="{{ $form_id }}">

            {{-- IMPORTANT: safer encoding --}}
            <input type="hidden"
                   name="valid_data"
                   value="{{ base64_encode(json_encode($valid)) }}">

            <button class="btn btn-success px-4">
                Confirm Import
            </button>

            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                Cancel
            </a>
        </form>

    </div>
</div>


</div>

@endsection
