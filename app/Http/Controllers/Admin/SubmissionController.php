<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Form;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $forms = Form::all();

        $submissions = Submission::with('data', 'form')
            ->when($request->form_id, function ($q) use ($request) {
                $q->where('form_id', $request->form_id);
            })
            ->latest()
            ->paginate(10);

        return view('admin.submissions.index', compact('submissions', 'forms'));
    }

    public function show($id)
    {
        $submission = Submission::with('data', 'form.fields')->findOrFail($id);

        return view('admin.submissions.show', compact('submission'));
    }

    public function destroy($id)
    {
        Submission::findOrFail($id)->delete();
        return back()->with('success', 'Deleted');
    }
}
