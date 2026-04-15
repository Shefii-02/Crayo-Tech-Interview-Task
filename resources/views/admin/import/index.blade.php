@extends('admin.layout')

@section('admin-content')
<h2 class="mb-3">Import CSV</h2>

<form method="POST" action="/admin/import/preview" enctype="multipart/form-data" class="card p-4">
    @csrf

    <div class="mb-3">
        <label>Select Form</label>

        <div class="d-flex gap-2">
            <select name="form_id" id="formSelect" class="form-control">
                @foreach ($forms as $form)
                    <option value="{{ $form->id }}">{{ $form->title }}</option>
                @endforeach
            </select>

            <a href="#" id="downloadSample" class="btn btn-info text-white">
                Download Sample
            </a>
        </div>
    </div>

    <div class="mb-3">
        <label>Upload CSV</label>
        <input type="file" name="file" class="form-control">
    </div>

    <button class="btn btn-success">Upload & Preview</button>
</form>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('downloadSample').addEventListener('click', function(e) {
        e.preventDefault();

        let formId = document.getElementById('formSelect').value;

        if (!formId) {
            alert('Please select a form');
            return;
        }

        window.location.href = `/admin/import/sample/${formId}`;
    });

});
</script>

@endsection
