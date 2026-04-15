<div class="field-box card mb-3 p-3">


    <input type="hidden" name="fields[{{ $i }}][id]" value="{{ $field->id ?? '' }}">
    <input type="hidden" name="fields[{{ $i }}][order]" class="order-input">

    <div class="row">
        <div class="col-md-1">
            <div class="mt-4 text-center mb-2">
                <i class="bi bi bi-arrows-move drag-handle me-2" style="cursor: grab;"></i>
            </div>
        </div>
        <div class="col-md-3">
            <label>Label</label>
            <input type="text" name="fields[{{ $i }}][label]" value="{{ $field->label ?? '' }}"
                class="form-control">
        </div>

        <div class="col-md-2">
            <label>Type</label>
            <select name="fields[{{ $i }}][type]" class="form-select" onchange="toggleOptions(this)">
                @php $type = $field->type ?? '' @endphp
                <option value="text" {{ $type == 'text' ? 'selected' : '' }}>Text</option>
                <option value="email" {{ $type == 'email' ? 'selected' : '' }}>Email</option>
                <option value="number" {{ $type == 'number' ? 'selected' : '' }}>Number</option>
                <option value="date" {{ $type == 'date' ? 'selected' : '' }}>Date</option>
                <option value="dropdown" {{ $type == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                <option value="checkbox" {{ $type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
            </select>
        </div>

        <div
            class="col-md-3 options-box {{ isset($field) && in_array($field->type, ['dropdown', 'checkbox']) ? '' : 'd-none' }}">
            <label>Options</label>
            <input type="text" name="fields[{{ $i }}][options]"
                value="{{ isset($field->options) ? implode(',', (array) $field->options) : '' }}" class="form-control"
                placeholder="a,b,c">
        </div>

        <div class="col-md-2 d-flex align-items-center">
            <div class="form-check mt-4">
                <input type="checkbox" name="fields[{{ $i }}][required]"
                    {{ isset($field) && $field->required ? 'checked' : '' }}>
                <label>Required</label>
            </div>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="button" onclick="removeField(this)" class="btn btn-danger w-100">
                Remove
            </button>
        </div>

    </div>


</div>
