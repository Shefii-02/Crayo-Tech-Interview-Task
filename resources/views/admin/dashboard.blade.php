@extends('admin.layout')

@section('admin-content')

<h2 class="mb-4">Dashboard</h2>

<div class="row">

    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5>Total Forms</h5>
                <h3>{{ \App\Models\Form::count() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5>Total Users</h5>
                <h3>{{ \App\Models\User::count() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5>Submissions</h5>
                <h3>{{ \App\Models\Submission::count() }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection
