@extends('admin.layout')

@section('admin-content')

<div class="container mt-4">


<div class="d-flex justify-content-between align-items-center">
    <h3>Submission #{{ $submission->id }}</h3>
    <a href="/admin/submissions" class="btn btn-secondary">Back</a>
</div>

<div class="card mt-3">
    <div class="card-body">

        <h5 class="mb-4">
            Form: <span class="text-primary">{{ $submission->form->title }}</span>
        </h5>

        <hr>

        {{-- SUBMISSION DATA --}}
        @php
            $fields = $submission->form->fields->keyBy('id');
        @endphp


        @foreach($submission->data as $fieldId => $value)

            @php
                $field = $fields[$fieldId] ?? null;
                $label = $field->label ?? 'Field '.$fieldId;
            @endphp

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>{{ $label }}</strong>
                </div>

                <div class="col-md-8">

                    @if(is_array($value))
                        <span class="badge bg-info text-dark">
                            {{ implode(', ', $value) }}
                        </span>
                    @else
                        <span class="badge bg-light text-dark">
                            {{ $value->value ?: '-' }}
                        </span>
                    @endif

                </div>
            </div>

        @endforeach

    </div>
</div>


</div>

@endsection
