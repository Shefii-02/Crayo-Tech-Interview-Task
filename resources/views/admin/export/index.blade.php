@extends('admin.layout')

@section('admin-content')

<div class="container mt-4">


<h2 class="mb-4">Export Submissions</h2>

<div class="card">
    <div class="card-body">

        <form method="GET" action="/admin/export/download" class="row g-3">

            {{-- FORM SELECT --}}
            <div class="col-md-6">
                <label class="form-label">Select Form</label>
                <select name="form_id" class="form-select" required>
                    <option value="">-- Choose Form --</option>

                    @foreach($forms as $form)
                        <option value="{{ $form->id }}">
                            {{ $form->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FORMAT (OPTIONAL FUTURE) --}}
            <div class="col-md-3">
                <label class="form-label">Format</label>
                <select name="type" class="form-select">
                    <option value="csv">CSV</option>
                    <option value="excel">Excel (soon)</option>
                </select>
            </div>

            {{-- BUTTON --}}
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-success w-100">
                    Download
                </button>
            </div>

        </form>

    </div>
</div>


</div>

@endsection
