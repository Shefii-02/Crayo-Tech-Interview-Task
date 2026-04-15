<!DOCTYPE html>
<html>

<head>
    <title>{{ $form->title }}</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="mb-4 text-center">{{ $form->title }}</h3> {{-- SUCCESS MESSAGE --}} @if (session('success'))
                        <div class="alert alert-success"> {{ session('success') }} </div>
                        @endif <form method="POST"> @csrf @foreach ($form->fields->sortBy('order') as $field)
                                <div class="mb-3"> <label class="form-label"> {{ $field->label }} @if ($field->required)
                                            <span class="text-danger">*</span>
                                            @endif </label> {{-- TEXT / EMAIL / NUMBER --}} @if (in_array($field->type, ['text', 'email', 'number']))
                                        <input type="{{ $field->type }}" name="{{ $field->name }}"
                                            value="{{ old($field->name) }}"
                                            class="form-control @error($field->name) is-invalid @enderror"
                                            placeholder="{{ $field->placeholder }}">
                                        @endif {{-- DATE --}} @if ($field->type == 'date')
                                            <input type="date" name="{{ $field->name }}"
                                                value="{{ old($field->name) }}"
                                                class="form-control @error($field->name) is-invalid @enderror">
                                            @endif {{-- DROPDOWN --}} @if ($field->type == 'dropdown')
                                                <select name="{{ $field->name }}"
                                                    class="form-select @error($field->name) is-invalid @enderror">
                                                    <option value="">Select</option>
                                                    @foreach ($field->options ?? [] as $opt)
                                                        <option value="{{ $opt }}"
                                                            {{ old($field->name) == $opt ? 'selected' : '' }}>
                                                            {{ $opt }} </option>
                                                    @endforeach
                                                </select>
                                                @endif {{-- CHECKBOX --}} @if ($field->type == 'checkbox')
                                                    <div class="mt-2">
                                                        @foreach ($field->options ?? [] as $opt)
                                                            <div class="form-check"> <input class="form-check-input"
                                                                    type="checkbox" name="{{ $field->name }}[]"
                                                                    value="{{ $opt }}"
                                                                    {{ is_array(old($field->name)) && in_array($opt, old($field->name)) ? 'checked' : '' }}>
                                                                <label class="form-check-label"> {{ $opt }}
                                                                </label> </div>
                                                        @endforeach
                                                    </div>
                                                @endif {{-- ERROR --}} @error($field->name)
                                                <div class="invalid-feedback d-block"> {{ $message }} </div>
                                            @enderror </div>
                        @endforeach <button type="submit" class="btn btn-primary w-100">
                            Submit </button> </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
