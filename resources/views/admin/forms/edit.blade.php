@extends('admin.layout')

@section('admin-content')
    <div class="container-fluid">


        <h2 class="mb-4">Edit Form</h2>

        <form method="POST" action="/admin/forms/{{ $form->id }}">
            @csrf
            @method('PUT')

            {{-- FORM INFO --}}
            <div class="card mb-4">
                <div class="card-body row">

                    <div class="col-md-6">
                        <label>Form Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $form->title }}">
                    </div>

                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $form->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$form->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>
            </div>

            {{-- FIELDS --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h5>Fields</h5>
                    <button type="button" onclick="addField()" class="btn btn-primary btn-sm">
                        + Add Field
                    </button>
                </div>

                <div class="card-body" id="fields-container"></div>
            </div>

            <button class="btn btn-success">Update Form</button>

        </form>


    </div>

    {{-- TEMPLATE (same as create) --}} <template id="field-template">

        <div class="field-box card mb-3 p-3 position-relative">
            <div class="top-0 end-0 text-end">
                <i type="button" onclick="removeField(this)" class="text-danger bg-danger-subtle rounded small">
                    <span class="me-2 bi bi-x">Delete</span>
                </i>
            </div>

            <input type="hidden" name="fields[__INDEX__][id]">
            <input type="hidden" name="fields[__INDEX__][order]" class="order-input">

            <div class="row align-items-center">


                <div class="col-md-1 text-center">
                    <i class="bi bi-arrows-move drag-handle"></i>
                </div>

                <div class="col-md-2">
                    <label>Label</label>
                    <input type="text" name="fields[__INDEX__][label]" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>Type</label>
                    <select name="fields[__INDEX__][type]" class="form-select" onchange="handleFieldChange(this)">
                        <option value="text">Text</option>
                        <option value="email">Email</option>
                        <option value="number">Number</option>
                        <option value="date">Date</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="checkbox">Checkbox</option>
                    </select>
                </div>

                <div class="col-md-3 options-box d-none">
                    <label>Options</label>
                    <input type="text" name="fields[__INDEX__][options]" class="form-control">
                </div>

                <div class="col-md-1 min-box d-none">
                    <label>Min</label>
                    <input type="number" name="fields[__INDEX__][min]" class="form-control">
                </div>

                <div class="col-md-1 max-box d-none">
                    <label>Max</label>
                    <input type="number" name="fields[__INDEX__][max]" class="form-control">
                </div>

                <div class="col-md-1">
                   <div class="form-check mt-4 d-flex align-items-center">
                        <input type="checkbox" name="fields[__INDEX__][required]">
                        <label class="ms-1">Required</label>
                    </div>
                </div>



            </div>


        </div>
    </template>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        let index = 0;

        // ADD FIELD (WITH DATA)
        function addField(data = null) {

            let template = document.getElementById('field-template').innerHTML;
            template = template.replace(/__INDEX__/g, index);

            let div = document.createElement('div');
            div.innerHTML = template;

            let el = div.firstElementChild;

            if (data) {
                el.querySelector('[name*="[id]"]').value = data.id;
                el.querySelector('[name*="[label]"]').value = data.label;
                el.querySelector('[name*="[type]"]').value = data.type;

                if (data.required) {
                    el.querySelector('[name*="[required]"]').checked = true;
                }

                if (data.options) {
                    el.querySelector('[name*="[options]"]').value = data.options.join(',');
                }

                if (data.min) {
                    el.querySelector('[name*="[min]"]').value = data.min;
                }

                if (data.max) {
                    el.querySelector('[name*="[max]"]').value = data.max;
                }
            }

            document.getElementById('fields-container').appendChild(el);

            handleFieldChange(el.querySelector('select'));

            index++;
        }

        // LOAD EXISTING FIELDS
        document.addEventListener('DOMContentLoaded', function() {

            let fields = @json($form->fields);

            fields.forEach(field => {
                addField(field);
            });

        });


        // REMOVE
        function removeField(btn) {
            btn.closest('.field-box').remove();
        }

        // FIELD LOGIC
        function handleFieldChange(select) {

            let row = select.closest('.row');

            let options = row.querySelector('.options-box');
            let min = row.querySelector('.min-box');
            let max = row.querySelector('.max-box');

            options.classList.add('d-none');
            min.classList.add('d-none');
            max.classList.add('d-none');

            if (select.value === 'dropdown' || select.value === 'checkbox') {
                options.classList.remove('d-none');
            }

            if (select.value === 'text' || select.value === 'number') {
                min.classList.remove('d-none');
                max.classList.remove('d-none');
            }
        }


        // DRAG
        new Sortable(document.getElementById('fields-container'), {
            animation: 150,
            handle: '.drag-handle',
            onEnd: updateOrderInputs
        });

        // SAVE ORDER
        document.querySelector('form').addEventListener('submit', function() {
            updateOrderInputs();
        });

        function updateOrderInputs() {
            document.querySelectorAll('.field-box').forEach((el, i) => {
                el.querySelector('.order-input').value = i;
            });
        }
    </script>
@endsection
