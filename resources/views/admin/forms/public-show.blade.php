<!DOCTYPE html>
<html>
<head>
    <title>{{ $form->title }}</title>
</head>
<body>

<h2>{{ $form->title }}</h2>

@if(session('success'))
    <div style="color:green;">
        {{ session('success') }}
    </div>
@endif

<form method="POST">
    @csrf

    @foreach($form->fields as $field)

        <div style="margin-bottom:15px;">
            <label>{{ $field->label }}</label><br>

            {{-- TEXT --}}
            @if($field->type == 'text' || $field->type == 'email' || $field->type == 'number')
                <input type="{{ $field->type }}"
                       name="{{ $field->name }}"
                       value="{{ old($field->name) }}"
                       placeholder="{{ $field->placeholder }}">
            @endif

            {{-- DATE --}}
            @if($field->type == 'date')
                <input type="date"
                       name="{{ $field->name }}">
            @endif

            {{-- DROPDOWN --}}
            @if($field->type == 'dropdown')
                <select name="{{ $field->name }}">
                    <option value="">Select</option>
                    @foreach($field->options ?? [] as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
            @endif

            {{-- CHECKBOX --}}
            @if($field->type == 'checkbox')
                @foreach($field->options ?? [] as $opt)
                    <label>
                        <input type="checkbox"
                               name="{{ $field->name }}[]"
                               value="{{ $opt }}">
                        {{ $opt }}
                    </label>
                @endforeach
            @endif

            {{-- ERROR --}}
            @error($field->name)
                <div style="color:red;">
                    {{ $message }}
                </div>
            @enderror

        </div>

    @endforeach

    <button type="submit">Submit</button>

</form>

</body>
</html>
