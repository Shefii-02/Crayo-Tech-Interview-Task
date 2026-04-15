@extends('admin.layout')

@section('admin-content')

<div class="container mt-4">


<h2 class="mb-4">Form Details</h2>

{{-- FORM INFO --}}
<div class="card mb-4">
    <div class="card-body">

        <h4 class="mb-2">{{ $form->title }}</h4>

        <span class="badge {{ $form->status ? 'bg-success' : 'bg-secondary' }}">
            {{ $form->status ? 'Active' : 'Inactive' }}
        </span>

    </div>
</div>

{{-- FORM FIELDS --}}
<div class="card mb-4">
    <div class="card-header">
        <strong>Fields</strong>
    </div>

    <div class="card-body p-0">

        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>Label</th>
                    <th>Type</th>
                    <th>Required</th>
                    <th>Options</th>
                </tr>
            </thead>

            <tbody>
                @forelse($form->fields as $field)
                    <tr>
                        <td>{{ $field->label }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ ucfirst($field->type) }}
                            </span>
                        </td>
                        <td>
                            @if($field->required)
                                <span class="badge bg-danger">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            @if($field->options)
                                {{ implode(', ', $field->options) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No fields found</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

{{-- PUBLIC LINK --}}
<div class="mb-4">
    <a href="{{ url('/admin/form/public/'.$form->id) }}"
       target="_blank"
       class="btn btn-primary">
        Open Public Form
    </a>
</div>

{{-- SUBMISSIONS --}}
<div class="card">
    <div class="card-header">
        <strong>Submissions</strong>
    </div>

    <div class="card-body p-0">

        @if($form->submissions->count())

            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="80">ID</th>
                        <th>Data</th>
                        <th width="180">Date</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($form->submissions as $submission)

                        <tr>
                            <td>{{ $submission->id }}</td>

                            <td>

                                @php
                                    $fields = $form->fields->keyBy('id');
                                @endphp

                                @foreach($submission->data as $fieldId => $value)

                                    <div class="mb-1">
                                        <strong>
                                            {{ $fields[$fieldId]->label ?? 'Field '.$fieldId }}:
                                        </strong>

                                        @if(is_array($value))
                                            {{ implode(', ', $value) }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </div>

                                @endforeach

                            </td>

                            <td>
                                {{ $submission->created_at->format('d M Y, h:i A') }}
                            </td>

                        </tr>

                    @endforeach
                </tbody>

            </table>

        @else
            <div class="p-3 text-muted text-center">
                No submissions yet.
            </div>
        @endif

    </div>
</div>


</div>

@endsection
