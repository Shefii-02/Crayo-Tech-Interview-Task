@extends('admin.layout')

@section('content')
<h1 class="text-2xl mb-4">Dashboard</h1>

<div class="grid grid-cols-3 gap-4">
    <div class="bg-white p-4 shadow">
        Forms: {{ \App\Models\Form::count() }}
    </div>

    <div class="bg-white p-4 shadow">
        Users: {{ \App\Models\User::count() }}
    </div>

    <div class="bg-white p-4 shadow">
        Submissions: {{ \App\Models\Submission::count() }}
    </div>
</div>
@endsection
