@extends('admin.layout')

@section('content')

<h2 class="text-xl mb-4">Form Details</h2>

{{-- FORM INFO --}}
<div class="border p-4 mb-4">
    <h3 class="text-lg font-bold">{{ $form->title }}</h3>
    <p>Status: {{ $form->status ? 'Active' : 'Inactive' }}</p>
</div>

{{-- FORM FIELDS --}}
<div class="border p-4 mb-4">
    <h3 class="font-bold mb-2">Fields</h3>

    <table class="w-full border">
        <tr class="bg-gray-100">
            <th class="p-2 border">Label</th>
            <th class="p-2 border">Type</th>
            <th class="p-2 border">Required</th>
            <th class="p-2 border">Options</th>
        </tr>

        @foreach($form->fields as $field)
            <tr>
                <td class="p-2 border">{{ $field->label }}</td>
                <td class="p-2 border">{{ $field->type }}</td>
                <td class="p-2 border">
                    {{ $field->required ? 'Yes' : 'No' }}
                </td>
                <td class="p-2 border">
                    @if($field->options)
                        {{ implode(', ', $field->options) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>

{{-- PUBLIC FORM LINK --}}
<div class="mb-4">
    <a href="{{ url('/admin/form/public/'.$form->id) }}" target="_blank"
       class="bg-blue-500 text-white px-3 py-2">
        Open Public Form
    </a>
</div>

{{-- SUBMISSIONS --}}
<div class="border p-4">
    <h3 class="font-bold mb-2">Submissions</h3>

    @if($form->submissions->count())
        <table class="w-full border">

            <tr class="bg-gray-100">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Data</th>
                <th class="p-2 border">Date</th>
            </tr>

            @foreach($form->submissions as $submission)
                <tr>
                    <td class="p-2 border">{{ $submission->id }}</td>

                    <td class="p-2 border">
                        @foreach($submission->data as $data)
                            <div>
                                <strong>{{ $data->field->label ?? '' }}:</strong>
                                {{ is_array($data->value) ? implode(',', json_decode($data->value, true)) : $data->value }}
                            </div>
                        @endforeach
                    </td>

                    <td class="p-2 border">
                        {{ $submission->created_at }}
                    </td>
                </tr>
            @endforeach

        </table>
    @else
        <p>No submissions yet.</p>
    @endif
</div>

@endsection
