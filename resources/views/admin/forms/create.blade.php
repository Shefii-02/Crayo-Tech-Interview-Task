@extends('admin.layout')

@section('content')

<h2 class="text-xl mb-4">Create Form</h2>

<form method="POST" action="/admin/forms">
    @csrf

    {{-- FORM TITLE --}}
    <div class="mb-4">
        <label>Form Title</label>
        <input type="text" name="title" class="border w-full p-2"
               value="{{ old('title') }}">
    </div>

    {{-- FIELDS --}}
    <div id="fields-container">

        @if(old('fields'))
            @foreach(old('fields') as $i => $field)
                <div class="field-box border p-3 mb-3">

                    <input type="text"
                           name="fields[{{ $i }}][label]"
                           placeholder="Label"
                           value="{{ $field['label'] }}"
                           class="border p-2 w-full mb-2">

                    <select name="fields[{{ $i }}][type]" class="border p-2 w-full mb-2">
                        <option value="text" {{ $field['type']=='text'?'selected':'' }}>Text</option>
                        <option value="email" {{ $field['type']=='email'?'selected':'' }}>Email</option>
                        <option value="number" {{ $field['type']=='number'?'selected':'' }}>Number</option>
                        <option value="date" {{ $field['type']=='date'?'selected':'' }}>Date</option>
                        <option value="dropdown" {{ $field['type']=='dropdown'?'selected':'' }}>Dropdown</option>
                        <option value="checkbox" {{ $field['type']=='checkbox'?'selected':'' }}>Checkbox</option>
                    </select>

                    <input type="text"
                           name="fields[{{ $i }}][options]"
                           placeholder="Options (comma separated)"
                           value="{{ $field['options'] ?? '' }}"
                           class="border p-2 w-full mb-2">

                    <label>
                        <input type="checkbox"
                               name="fields[{{ $i }}][required]"
                               {{ isset($field['required']) ? 'checked' : '' }}>
                        Required
                    </label>

                    <button type="button" onclick="removeField(this)" class="text-red-500 ml-3">
                        Remove
                    </button>

                </div>
            @endforeach
        @endif

    </div>

    {{-- ADD FIELD BUTTON --}}
    <button type="button" onclick="addField()" class="bg-blue-500 text-white px-3 py-2">
        Add Field
    </button>

    <br><br>

    <button class="bg-green-500 text-white px-4 py-2">
        Save Form
    </button>

</form>

{{-- TEMPLATE (IMPORTANT) --}}
<template id="field-template">
    <div class="field-box border p-3 mb-3">

        <input type="text"
               name="__NAME__[label]"
               placeholder="Label"
               class="border p-2 w-full mb-2">

        <select name="__NAME__[type]" class="border p-2 w-full mb-2">
            <option value="text">Text</option>
            <option value="email">Email</option>
            <option value="number">Number</option>
            <option value="date">Date</option>
            <option value="dropdown">Dropdown</option>
            <option value="checkbox">Checkbox</option>
        </select>

        <input type="text"
               name="__NAME__[options]"
               placeholder="Options (comma separated)"
               class="border p-2 w-full mb-2">

        <label>
            <input type="checkbox" name="__NAME__[required]">
            Required
        </label>

        <button type="button" onclick="removeField(this)" class="text-red-500 ml-3">
            Remove
        </button>

    </div>
</template>

{{-- JS --}}
<script>

let index = {{ old('fields') ? count(old('fields')) : 0 }};

function addField() {
    let template = document.getElementById('field-template').innerHTML;

    template = template.replace(/__NAME__/g, `fields[${index}]`);

    let div = document.createElement('div');
    div.innerHTML = template;

    document.getElementById('fields-container').appendChild(div);

    index++;
}

function removeField(btn) {
    btn.closest('.field-box').remove();
}

</script>

@endsection
