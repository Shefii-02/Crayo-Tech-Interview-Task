@extends('admin.layout')

@section('admin-content')

<div class="container mt-4">


<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Submissions</h2>
</div>

{{-- FILTER --}}
<div class="card mb-3">
    <div class="card-body">

        <form method="GET" class="row g-2">

            <div class="col-md-4">
                <select name="form_id" class="form-select">
                    <option value="">All Forms</option>

                    @foreach(\App\Models\Form::all() as $form)
                        <option value="{{ $form->id }}"
                            {{ request('form_id') == $form->id ? 'selected' : '' }}>
                            {{ $form->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>

            <div class="col-md-2">
                <a href="/admin/submissions" class="btn btn-secondary w-100">Reset</a>
            </div>

        </form>

    </div>
</div>

{{-- TABLE --}}
<div class="card">
    <div class="card-body p-0">

        <table class="table table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th width="80">ID</th>
                    <th>Form</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($submissions as $sub)
                    <tr>
                        <td>{{ $sub->id }}</td>
                        <td>{{ $sub->form->title ?? '-' }}</td>
                        <td>

                            <a href="/admin/submissions/{{ $sub->id }}"
                               class="btn btn-sm btn-info">
                               View
                            </a>

                            <form method="POST"
                                  action="/admin/submissions/{{ $sub->id }}"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this submission?')">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No submissions found</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-3">
    {{ $submissions->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>


</div>

@endsection
