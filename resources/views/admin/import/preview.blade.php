@extends('admin.layout')

@section('admin-content')

<div class="container-fluid">

    <h3 class="mb-4">Import Preview</h3>

    {{-- VALID ROWS --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Valid Rows ({{ count($valid) }})
        </div>

        <div class="card-body">

            @if(count($valid))

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                        <thead class="table-light">
                            <tr>
                                @foreach(array_keys($valid[0]) as $head)
                                    <th>{{ ucfirst($head) }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($valid as $row)
                                <tr>
                                    @foreach($row as $value)
                                        <td>
                                            @if(is_array($value))
                                                {{ implode(', ', $value) }}
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            @else
                <p class="text-muted mb-0">No valid rows</p>
            @endif

        </div>
    </div>

    {{-- INVALID ROWS --}}
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            Invalid Rows ({{ count($invalid) }})
        </div>

        <div class="card-body">

            @if(count($invalid))

                <table class="table table-bordered">

                    <thead class="table-light">
                        <tr>
                            <th>Row</th>
                            <th>Errors</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($invalid as $row)
                            <tr>
                                <td>{{ $row['row'] }}</td>
                                <td>
                                    <ul class="mb-0 text-danger">
                                        @foreach($row['errors'] as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            @else
                <p class="text-muted mb-0">No invalid rows 🎉</p>
            @endif

        </div>
    </div>

    {{-- CONFIRM IMPORT --}}
    @if(count($valid))
        <form method="POST" action="/admin/import/store">
            @csrf

            <input type="hidden" name="form_id" value="{{ $form_id }}">
            <input type="hidden" name="valid_data" value="{{ json_encode($valid) }}">

            <button class="btn btn-success">
                ✅ Confirm Import ({{ count($valid) }} rows)
            </button>
        </form>
    @endif

</div>

@endsection
